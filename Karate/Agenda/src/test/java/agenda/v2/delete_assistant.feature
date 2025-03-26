Feature: Delete Assistant API

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * def loginResponse = call read('login.feature@login_admin')
        * def authToken = loginResponse.tokenAuth
        * print 'Auth Token:', authToken
        * header Authorization = 'Bearer ' + authToken
        * def randomEmail = 'assistant' + java.lang.System.currentTimeMillis() + '@example.com'
        * print 'Generated Email:', randomEmail

    @registerAndDeleteAssistant
    Scenario: Register and then delete an Assistant
        # 1️⃣ Registrar un nuevo usuario assistant
        Given path 'admin/register'
        And request
        """
        {
            "name": "John Assistant",
            "email": "#(randomEmail)",
            "password": "password",
            "password_confirmation": "password",
            "rol": "Assistant"
        }
        """
        When method post
        Then status 201
        And match response.message == 'User registered successfully'
        * def userId = response.user.id
        * print 'Registered User ID:', userId

        # 2️⃣ Eliminar el usuario registrado
        Given path 'admin/delete/' + userId
        When method delete
        Then status 200
        And match response.message == 'User and related data deleted successfully'
