Feature: Get all persons

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * path '/people'
        * method get
        * status 200
        * match response == '#[]'

    Scenario: Valid to response will be array
        Then assert response.length > 0

    Scenario: Valid data from response
        Then match $[0].id == '#number'
        And  match $[0].nombre == '#present'
        And  match $[0].tags == '#[]'
        And  match $[0].media == '#[]'


