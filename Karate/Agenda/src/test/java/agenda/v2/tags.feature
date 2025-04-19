Feature: Tag API - Mass Add

  Background:
    * url 'https://back.agenda.peryloth.com/api/'
    * def token = call read('login.feature@login_success') { email: 'test@example.com', password: 'password' }

  @AddTags
  Scenario: Add multiple tags
    * def personId = call read('person.feature@createPerson')
    Given path 'tags/add/' + personId.personId
    And request {"token": #(token.tokenAuth),"tags": [{ "valor": "Tag1", "tipo": "Type1" },{ "valor": "Tag2", "tipo": "Type2" }]}
    When method post
    Then status 200
    And match response[0].valor == 'Tag1'
    And match response[1].valor == 'Tag2'
    * def tagIds = karate.map(response, function(x){ return x.id })
    * print 'IDs de tags creados:', tagIds
    * def result = tagIds
    * print 'IDs de tags creados:', tagIds


  @UpdateTags
  Scenario: Update multiple tags
    * def tagIds = call read('tags.feature@AddTags')
    * print 'IDs de tags creados para update:', tagIds.result
    Given path 'tags/update'
    And request {"token": #(token.tokenAuth),"tags": [{ "id": #(tagIds.result[0]), "valor": "Tag1 Updated", "tipo": "Type1" },{ "id": #(tagIds.result[1]), "valor": "Tag2 Updated", "tipo": "Type2" }]}
    When method put
    Then status 200
    And match response.message == 'Tags actualizados correctamente'

  @DeleteTags
  Scenario: Delete multiple tags
    * def tagIds = call read('tags.feature@AddTags')
    * print 'IDs de tags creados para delete:', tagIds.result
    * def tagsToDelete = tagIds.result
    Given path 'tags/delete'
    And request { "token": #(token.tokenAuth), "tags": #(tagsToDelete) }
    When method delete
    Then status 200
    And match response.message == 'Tags eliminados correctamente'
