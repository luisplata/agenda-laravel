Feature: List type_of_massage

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of type_of_massage
        Given path 'typeOfMassage'
        When method GET
        Then status 200
        And match response.type_of_massage contains ["Convencional", "Erotico", "Relajante", "Sensitivo", "Tántrico", "Estimulante", "Prostático", "Antiestres"]
