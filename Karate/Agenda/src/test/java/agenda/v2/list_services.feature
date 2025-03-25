Feature: List services

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'services'
        When method GET
        Then status 200
        And match response.services contains ["Presencial", "A Domicilio", "Virtual", "Masajista", "Streaptease"]
