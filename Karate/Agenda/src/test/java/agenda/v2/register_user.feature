Feature: User Registration

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Successful user registration
        * def randomEmail = 'user_' + karate.timestamp() + '@example.com'
        Given path 'register'
        And request { "name": "John Doe", "email": "#(randomEmail)", "password": "secret123", "password_confirmation": "secret123" }
        When method POST
        Then status 201
        And match response.message == "User registered successfully"
        And match response.user.name == "John Doe"
        And match response.user.email == "john@example.com"
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
        And request { "name": "Jane Doe", "email": "existing@example.com", "password": "secret123", "password_confirmation": "secret123" }
        When method POST
        Then status 422
        And match response.errors.email[0] contains "already been taken"

    Scenario: Registration fails due to password confirmation mismatch
        Given path 'register'
        And request { "name": "John Doe", "email": "john@example.com", "password": "secret123", "password_confirmation": "wrongpassword" }
        When method POST
        Then status 422
        And match response.errors.password[0] contains "confirmation"
