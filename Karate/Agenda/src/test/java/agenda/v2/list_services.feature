Feature: List Services

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'list_services'
        When method GET
        Then status 200
        And match response.services contains ["Presencial", "A DomicilioVirtual", "Masajista", "Streaptease"]
