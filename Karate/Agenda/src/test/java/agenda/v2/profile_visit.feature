Feature: Profile Visit

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * def loginResponse = call read('login.feature@login_success') { email: 'model@example.com', password: 'password' }
        * def authToken = loginResponse.tokenAuth

    Scenario: Register a profile visit
        Given path 'profile/visit'
        And header Authorization = 'Bearer ' + authToken
        And request { "token": "#(authToken)" }
        When method POST
        Then status 201
        And match response.message == "Visita registrada con éxito"
