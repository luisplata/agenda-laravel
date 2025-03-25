Feature: List additional additional_services

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of additional_services
        Given path 'additionalServices'
        When method GET
        Then status 200
        And match response.additional_services contains ["Eyaculación Cuerpo", "Eyaculación Pecho", "Eyaculacion Facial", "Mujeres y Hombres", "Atención a Parejas", "Trios M/H/M", "Trios H/M/H", "Lesbicos", "Poses varias", "Besos", "Bailes"]
