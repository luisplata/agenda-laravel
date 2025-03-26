Feature: People API

    Scenario: Get all people
        * call read('register_user.feature@register_success')
        Given url 'https://back.agenda.peryloth.com/api/people'
        When method get
        Then status 200
        And match response != null

    Scenario: Get a person by ID
        * def personId = call read('person.feature@createPerson')
        Given url 'https://back.agenda.peryloth.com/api/people/' + personId.personId
        When method get
        Then status 200
        * match personId != null
        And match response.id == personId.personId

    Scenario: Increment views by ID
        * def personId = call read('person.feature@createPerson')
        Given url 'https://back.agenda.peryloth.com/api/increment/' + personId.personId
        When method get
        Then status 200
        And match response contains { views: '#notnull' }
