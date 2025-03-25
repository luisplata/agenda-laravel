Feature: List oral type

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of oral type
        Given path 'oralType'
        When method GET
        Then status 200
        And match response.oral_type contains ["Al Natural", "Con Protección", "Garganta profunda", "69"]
