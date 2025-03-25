Feature: Auth API

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * def loginResponse = call read('login.feature@login_success') { email: 'model@example.com', password: 'password' }
        * def authToken = loginResponse.tokenAuth
        * def expectedEmail = loginResponse.loggedUser
        * print 'Token obtenido:', authToken

    Scenario: Get user details
        Given path 'me'
        And request { "token": "#(authToken)" }
        * header Content-Type = 'application/json'
        When method get
        Then status 200
        And match response.email == expectedEmail

    Scenario: Logout
        Given path 'logout'
        * request { "token": "#(authToken)" }
        * header Content-Type = 'application/json'
        When method post
        Then status 200
        And match response.message == 'Sesión cerrada'
