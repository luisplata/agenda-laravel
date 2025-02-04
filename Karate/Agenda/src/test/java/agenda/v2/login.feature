Feature: Login API

    Scenario: Unsuccessful login
        Given url 'https://backend.newpage.peryloth.com/api/login'
        And request { "email": "test@example.com", "password": "wrongpassword" }
        When method post
        Then status 401
        And match response.message == 'Credenciales incorrectas'

    @login_success
    Scenario: Successful login
        Given url 'https://backend.newpage.peryloth.com/api/login'
        And request { "email": "test@example.com", "password": "password" }
        When method post
        Then status 200
        And match response.token != null
        * def tokenAuth = response.token
