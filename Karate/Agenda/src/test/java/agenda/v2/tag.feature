Feature: Tag API

    Background:
        * url 'https://backend.newpage.peryloth.com/api'
        * def token = call read('login.feature@login_success') { email: 'test@example.com', password: 'password' }

    @AddTag
    Scenario: Add a tag
        * def personId = call read('person.feature@createPerson')
        Given path 'add-tag/' + personId.personId
        And request { "token": #(token.tokenAuth), "valor": "Tag1", "tipo": "Type1" }
        When method post
        Then status 200
        And match response[0].valor == 'Tag1'
        * def tagId = response[0].id

    Scenario: Update a tag
        * def tagId = call read('tag.feature@AddTag')
        Given path 'update-tag/' + tagId.tagId
        And request { "token": #(token.tokenAuth), "valor": "Tag1 Updated", "tipo": "Type1" }
        When method put
        Then status 200
        And match response.valor == 'Tag1 Updated'

    Scenario: Delete a tag
        * def tagId = call read('tag.feature@AddTag')
        Given path 'delete-tag/' + tagId.tagId
        And request { "token": #(token.tokenAuth) }
        When method delete
        Then status 200
        And match response.message == 'Tag eliminada'
