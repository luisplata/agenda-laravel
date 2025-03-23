Feature: List Categories

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of categories
        Given path 'list_categories'
        When method GET
        Then status 200
        And match response.categories == ["Dama", "Virtual", "Dama Virtual", "Trans", "Trans Virtual", "Caballero de Compañía", "Caballero Virtual", "Masajista"]
