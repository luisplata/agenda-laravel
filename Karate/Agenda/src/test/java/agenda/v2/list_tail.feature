Feature: List Tails

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of tail
        Given path 'tail'
        When method GET
        Then status 200
        And match response.tail contains ["Pequeña", "Normal", "Grande", "Gigante"]
