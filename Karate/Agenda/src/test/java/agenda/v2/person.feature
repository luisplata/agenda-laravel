Feature: Person API

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * def loginResponse = call read('login.feature@login_test')
        * print 'Login Response:', loginResponse
        * def authToken = loginResponse.tokenAuth
        * def loggedUser = loginResponse.loggedUser
        * print 'Auth Token:', authToken
        * print 'Logged User:', loggedUser
        * match loggedUser == 'test@example.com'


    @createPerson
    Scenario: Create a person
        Given path 'create'
        And request { "token": "#(authToken)", "nombre": "John Doe", "about": "About John", "horario": "9-5", "tarifa": "100", "whatsapp": "1234567890", "telegram": "johndoe", "mapa": "location" }
        When method post
        Then status 201
        And match response.nombre == 'John Doe'
        * print 'Response from createPerson:', response
        * def personId = response.id


    Scenario: Update a person
        * def personId = call read('person.feature@createPerson')
        Given path 'update/'+ personId.personId
        And request { "token": "#(authToken)", "nombre": "John Doe Updated", "about": "About John Updated", "horario": "10-6", "tarifa": "150", "whatsapp": "0987654321", "telegram": "johnupdated", "mapa": "new location" }
        When method put
        Then status 200
        And match response.nombre == 'John Doe Updated'

    Scenario: Delete a person
        * def personId = call read('person.feature@createPerson')
        * match loggedUser == 'test@example.com'
        * print 'Using Auth Token:', authToken
        Given path 'delete/' + personId.personId
        And request { "token": "#(authToken)" }
        When method delete
        Then status 200
        And match response.message == 'Persona eliminada'


