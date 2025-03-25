Feature: List Tails

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'biotype'  # Asegúrate de que esta sea la ruta correcta
        When method GET
        Then status 200
        And match response.services contains ["Disfraces", "Lencería", "Juego de Roles", "Cambio de Roles", "Adoración de Pies", "Dominación", "Sumisa", "BDSM", "Lluvia Dorada", "Fisting", "Anal", "Squrit", "Sadomasoquismo", "A consultar"]
