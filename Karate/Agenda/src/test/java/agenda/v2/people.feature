Feature: People API

    Scenario: Get all people
        Given url 'https://backend.newpage.peryloth.com/api/people'
        When method get
        Then status 200
        And match response != null

    Scenario: Get a person by ID
        * def personId = call read('person.feature@createPerson')
        Given url 'https://backend.newpage.peryloth.com/api/people/' + personId.personId
        When method get
        Then status 200
        And match response.id == personId.personId
