Feature: Subscription Management

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario Outline: Register a model user
        * def randomEmail = 'user' + Math.floor(Math.random() * 100000) + '@example.com'
        Given path 'register'
        And request
    """
    {
        "name": "Model_Example",
        "email": "#(randomEmail)",
        "password": "password123",
        "password_confirmation": "password123",
        "role": "Model"
    }
    """
        When method post
        Then status 201
        And match response.message == 'User registered successfully'
        And match response.user.email == randomEmail
        * def userId = response.user.id

        Given path 'login'
        And request { "email": "#(randomEmail)", "password": "password123" }
        When method post
        Then status 200
        * def authToken = response.token

        Given path 'me'
        And request { "token": "#(authToken)" }
        When method get
        Then status 200
        * def userId = response.id

        Given path 'create'
        And request
       """
           {
               "nombre": "Test Model",
               "age": 25,
               "user_id": "#(userId)",
               "about": "About me",
                "horario": "Monday to Friday 9:00 - 18:00",
                "tarifa": 100,
                "whatsapp": "1234567890",
                "telegram": "test",
                "mapa": "https://goo.gl/maps/1234567890",
               "token": "#(authToken)"
           }
       """
        When method post
        Then status 201

        * def loginResponse = call read('login.feature@login_test')
        * def authTokenAdmin = loginResponse.tokenAuth

        Given path 'subscriptions', userId
        And request { "months": <months>, "token": "#(authTokenAdmin)" }
        When method post
        Then status 201
        And match response.subscription contains { expires_at: '#notnull' }

        Given path 'subscriptions/check'
        And request { "token": "#(authTokenAdmin)" }
        When method get
        Then status 200
        And match response.message == 'Verificación completada'

        Examples:
            | months |
            | 1      |
            | 2      |
            | 3      |
            | 4      |
