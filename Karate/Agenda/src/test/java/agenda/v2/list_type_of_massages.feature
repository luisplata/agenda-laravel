Feature: List Tails

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'biotype'
        When method GET
        Then status 200
        And match response.services contains ["Convencional", "Erotico", "Relajante", "Sensitivo", "Tántrico", "Estimulante", "Prostático", "Antiestres"]
