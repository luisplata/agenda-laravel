Feature: List all people as Admin

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Model creates a person and Admin retrieves it via all_people
        * def loginModel = call read('login.feature@login_model')
        * def authToken = loginModel.tokenAuth
        * def randomName = 'Person_' + java.lang.System.currentTimeMillis()
        * print 'Auth Token:', authToken

        Given path 'create'
        And request
    """
    {
      "token": "#(authToken)",
      "nombre": "#(randomName)",
      "about": "Test person about",
      "horario": "10-18",
      "tarifa": "150",
      "whatsapp": "123456789",
      "telegram": "testTelegram",
      "mapa": "some location"
    }
    """
        When method post
        Then status 201
        And match response.nombre == randomName
        * def createdPersonId = response.id
        * print 'Persona creada:', createdPersonId

        * def loginAdmin = call read('login.feature@login_test')
        * def tokenAdmin = loginAdmin.tokenAuth

        Given path 'all_people'
        And request { "token": "#(tokenAdmin)" }
        When method get
        Then status 200
        And match response[*].nombre contains randomName
