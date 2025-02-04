Feature: People API

    Scenario: Get all people
        Given url 'http://127.0.0.1:8000/api/people'
        When method get
        Then status 200
        And match response != null

    Scenario: Get a person by ID
        * def personId = call read('person.feature@createPerson')
        Given url 'http://localhost:8000/api/people/' + personId.personId
        When method get
        Then status 200
        And match response.id == personId.personId
