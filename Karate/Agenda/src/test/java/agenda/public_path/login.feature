Feature: Test Login about agenda API

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * def loginEndpoint = '/login'

    @login_success
    Scenario: Login success
        Given path loginEndpoint
        And request { "email": "test@example.com", "password": "password" }
        When method post
        Then status 200
        And match response contains { token: '#string' }
        * def authToken = response.token
        * print 'Token:', authToken

    @login_error
    Scenario Outline: Try login with wrong credentials
        Given path loginEndpoint
        And request { "email": "<email>", "password": "<password>" }
        When method post
        Then status <status_code>
        And match response == { "message" : "<message>" }

        Examples:
            | email                 | password    | status_code | message                           |
            | user@example.com      | wrongpass   | 401         | Credenciales incorrectas          |
            | nonexist@example.com  | password123 | 401         | Credenciales incorrectas         |

    @login_error_inputs_empty
    Scenario Outline: Try login without inputs data
        Given path loginEndpoint
        And request { "email":"<email>", "password":"<password>"}
        When method post
        Then status <status_code>
        And match response == { "<type_data>": [ "#present" ]}
        Examples:
        |email      |password   |status_code|type_data|
        |           |password   |422        |email    |
        |email@a.com|           |422        |password |

    @login_valid
    Scenario: Valid token and data
        Given path loginEndpoint
        And request { "email": "test@example.com", "password": "password" }
        When method post
        Then status 200
        And match response.token == '#present'
