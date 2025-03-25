Feature: Type of Body Services

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'typeOfBody'
        When method GET
        Then status 200
        And match response.services contains ["Delgado/a", "Robusto/a", "Voluptuoso/a", "Curvy", "BBW"]
