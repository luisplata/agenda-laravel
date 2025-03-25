Feature: List fantasy_type

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of fantasy_type
        Given path 'fantasyType'
        When method GET
        Then status 200
        And match response.fantasy_type contains ["Juguetes", "Disfraces", "Lencería", "Juego de Roles", "Cambio de Roles", "Adoración de Pies", "Dominación", "Sumisa", "BDSM", "Lluvia Dorada", "Fisting", "Anal", "Squirt", "Sadomasoquismo", "A consultar"]
