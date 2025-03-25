Feature: List Bust

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'bust'
        When method GET
        Then status 200
        And match response.services contains ["Pequeño", "Normal", "Grande", "Gigante"]
