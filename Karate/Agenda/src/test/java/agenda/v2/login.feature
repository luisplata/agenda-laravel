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
        * print 'Login Response:', response
        And match response.token != null
        * def tokenAuth = response.token
        * def loggedUser = "<email>"

        Examples:
            | email              | password  |
            | test@example.com   | password  |
            | model@example.com  | password  |


    @login_test
    Scenario: Login with test user
        Given url 'https://back.agenda.peryloth.com/api/login'
        And request { "email": "test@example.com", "password": "password" }
        When method post
        Then status 200
        * print 'Login Response:', response
        And match response.token != null
        * def tokenAuth = response.token
        * def loggedUser = "test@example.com"

    @login_model
    Scenario: Login with model user
        Given url 'https://back.agenda.peryloth.com/api/login'
        And request { "email": "model@example.com", "password": "password" }
        When method post
        Then status 200
        * print 'Login Response:', response
        And match response.token != null
        * def tokenAuth = response.token
        * def loggedUser = "model@example.com"
