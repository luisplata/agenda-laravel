Feature: List biotype

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of biotype
        Given path 'bioType'
        When method GET
        Then status 200
        And match response.biotype contains ["Natural", "Operado/a"]
