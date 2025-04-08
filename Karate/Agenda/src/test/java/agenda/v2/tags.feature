Feature: Tag API - Mass Add

    Background:
        * url 'https://backend.newpage.peryloth.com/api'
        * def token = call read('login.feature@login_success') { email: 'test@example.com', password: 'password' }

    @AddTags
    Scenario: Add multiple tags
        * def personId = call read('person.feature@createPerson')
        Given path 'tags/' + personId.personId + '/add'
        And request { "token": #(token.tokenAuth),"tags": [{ "valor": "Tag1", "tipo": "Type1" },{ "valor": "Tag2", "tipo": "Type2" }]}
        When method post
        Then status 200
        And match response[0].valor == 'Tag1'
        And match response[1].valor == 'Tag2'
        * def tagIds = response[0].id + ',' + response[1].id


    @UpdateTags
    Scenario: Update multiple tags
        * def tagIds = call read('tag.feature@AddTags')  # Obtén los IDs de las tags creadas
        Given path 'tags/update'
        And request {"token": #(token.tokenAuth),"tags": [{ "id": #(tagIds[0]), "valor": "Tag1 Updated", "tipo": "Type1" },{ "id": #(tagIds[1]), "valor": "Tag2 Updated", "tipo": "Type2" }]}
        When method put
        Then status 200
        And match response.message == 'Tags actualizados correctamente'

    @DeleteTags
    Scenario: Delete multiple tags
        * def tagIds = call read('tag.feature@AddTags')  # Obtén los IDs de las tags creadas
        Given path 'tags/delete'
        And request {"token": #(token.tokenAuth),"tags": [ #(tagIds[0]), #(tagIds[1]) ]}
        When method delete
        Then status 200
        And match response.message == 'Tags eliminados correctamente'
