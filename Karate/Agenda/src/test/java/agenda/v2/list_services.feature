Feature: List Services

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'list_services'  # Asegúrate de que esta sea la ruta correcta
        When method GET
        Then status 200
        And match response.services contains ["Presencial", "A DomicilioVirtual", "Masajista", "Streaptease"]
