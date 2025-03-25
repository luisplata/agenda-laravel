Feature: Login API

    Scenario: Unsuccessful login
        Given url 'https://back.agenda.peryloth.com/api/login'
        And request { "email": "test@example.com", "password": "wrongpassword" }
        When method post
        Then status 401
        And match response.message == 'Credenciales incorrectas'

    @login_success
    Scenario Outline: Successful login with dynamic user
        Given url 'https://back.agenda.peryloth.com/api/login'
        And request { "email": "<email>", "password": "<password>" }
        When method post
        Then status 200
        And match response.token != null
        * def tokenAuth = response.token

        Examples:
            | email               | password  |
            | test@example.com    | password  |
            | model@example.com   | password  |
