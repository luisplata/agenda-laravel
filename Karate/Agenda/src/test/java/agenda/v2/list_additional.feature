Feature: List additional Services

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'additionalServices'  # Asegúrate de que esta sea la ruta correcta
        When method GET
        Then status 200
        And match response.services contains ["Eyaculación Cuerpo", "Eyaculación Pecho", "Eyaculacion Facial", "Mujeres y Hombres", "Atención a Parejas", "Trios M/H/M", "Trios H/M/H", "Lesbicos", "Poses varias", "Besos", "Bailes"]
