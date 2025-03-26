Feature: Register Assistant API

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * def loginResponse = call read('login.feature@login_test')
        * def authToken = loginResponse.tokenAuth
        * print 'Auth Token:', authToken
        * def randomEmail = 'assistant' + java.lang.System.currentTimeMillis() + '@example.com'

    @registerAssistant
    Scenario: Register an Assistant successfully
        Given path 'admin/register'
        And request
        """
        {
            "name": "John Assistant",
            "email": "#(randomEmail)",
            "password": "password",
            "password_confirmation": "password",
            "rol": "Assistant",
            "token": "#(authToken)"
        }
        """
        When method post
        Then status 201
        And match response.message == 'User registered successfully'
        And match response.user.email == randomEmail
        And match response.user.role == 'Assistant'

    @registerAssistant_duplicateEmail
    Scenario: Fail to register with duplicate email
        Given path 'admin/register'
        And request
        """
        {
            "name": "John Assistant",
            "email": "test@example.com",
            "password": "password",
            "password_confirmation": "password",
            "rol": "Assistant",
            "token": "#(authToken)"
        }
        """
        When method post
        Then status 422
        And match response.errors.email[0] contains 'The email has already been taken'

    @registerAssistant_missingFields
    Scenario: Fail to register with missing fields
        Given path 'admin/register'
        And request
        """
        {
            "name": "John Assistant",
            "password": "password",
            "password_confirmation": "password",
            "token": "#(authToken)"
        }
        """
        When method post
        Then status 422
        And match response.errors.email[0] contains 'The email field is required'
        And match response.errors.rol[0] contains 'The rol field is required'
