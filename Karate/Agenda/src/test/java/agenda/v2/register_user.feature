Feature: User Registration

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    @register_success
    Scenario: Successful user registration
        * def loginResponse = call read('login.feature@login_success') { email: 'model@example.com', password: 'password' }
        * def randomEmail = 'user_' + java.lang.System.currentTimeMillis() + '@example.com'
        Given path 'register'
        And request { "name": "John Doe", "email": "#(randomEmail)", "password": "secret123", "password_confirmation": "secret123" }
        When method POST
        Then status 201
        And match response.message == "User registered successfully"
        And match response.user.name == "John Doe"
        And match response.user.email == "#(randomEmail)"
        And match response.user.role == "Model"

    Scenario: Registration fails due to missing fields
        Given path 'register'
        And request { "name": "", "email": "", "password": "", "password_confirmation": "" }
        When method POST
        Then status 422
        And match response.errors.name[0] contains "required"
        And match response.errors.email[0] contains "required"
        And match response.errors.password[0] contains "required"

    Scenario: Registration fails due to email already taken
        Given path 'register'
        * def loginResponse = call read('register_user.feature@register_success')
        And request { "name": "Jane Doe", "email": "#(loginResponse.randomEmail)", "password": "secret123", "password_confirmation": "secret123" }
        When method POST
        Then status 422
        And match response.errors.email[0] contains "already been taken"

    Scenario: Registration fails due to password confirmation mismatch
        Given path 'register'
        And request { "name": "John Doe", "email": "john@example.com", "password": "secret123", "password_confirmation": "wrongpassword" }
        When method POST
        Then status 422
        And match response.errors.password[0] contains "confirmation"
