Feature: Person API

    Background:
        * url 'https://backend.newpage.peryloth.com/api'
        * def token = call read('login.feature@login_success') { email: 'test@example.com', password: 'password' }

    @createPerson
    Scenario: Create a person
        Given path 'create'
        And request { "token": #(token.tokenAuth), "nombre": "John Doe", "about": "About John", "horario": "9-5", "tarifa": "100", "whatsapp": "1234567890", "telegram": "johndoe", "mapa": "location" }
        When method post
        Then status 201
        And match response.nombre == 'John Doe'
        * def personId = response.id
        * print personId

    Scenario: Update a person
        * def personId = call read('person.feature@createPerson')
        Given path 'update/'+ personId.personId
        And request { "token": #(token.tokenAuth), "nombre": "John Doe Updated", "about": "About John Updated", "horario": "10-6", "tarifa": "150", "whatsapp": "0987654321", "telegram": "johnupdated", "mapa": "new location" }
        When method put
        Then status 200
        And match response.nombre == 'John Doe Updated'

    Scenario: Delete a person
        * def personId = call read('person.feature@createPerson')
        Given path 'delete/' + personId.personId
        And request { "token": #(token.tokenAuth)}
        When method delete
        Then status 200
        And match response.message == 'Persona eliminada'
