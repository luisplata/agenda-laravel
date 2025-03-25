Feature: Upload API

    Background:
        * url 'https://back.agenda.peryloth.com/api'
        * def loginResponse = call read('login.feature@login_test')
        * print 'Login Response:', loginResponse
        * def authToken = loginResponse.tokenAuth
        * def loggedUser = loginResponse.loggedUser
        * print 'Auth Token:', authToken
        * print 'Logged User:', loggedUser
        * match loggedUser == 'test@example.com'

    @UploadImage
    Scenario: Upload an image
        * def personId = call read('person.feature@createPerson')
        Given path 'upload/image/' + personId.personId
        And multipart file file = { read: 'classpath:sampleImage.jpg', filename: 'sampleImage.jpg', contentType: 'image/jpeg' }
        And multipart field token = authToken
        When method post
        Then status 201
        And match response.message == 'Imagen subida exitosamente'
        * def imagenId = response.media.id

    @UploadVideo
    Scenario: Upload a video
        * def personId = call read('person.feature@createPerson')
        Given path 'upload/video/' + personId.personId
        And multipart file file = { read: 'classpath:sampleVideo.mp4', filename: 'sampleVideo.mp4', contentType: 'video/mp4' }
        And multipart field token = authToken
        When method post
        Then status 201
        And match response.message == 'Video subido exitosamente'
        * def videoId = response.media.id

    Scenario: Delete media
        * def imagenId = call read('upload.feature@UploadImage')
        Given path 'upload/image/' + imagenId.imagenId
        And request { "token": "#(authToken)" }
        When method delete
        Then status 200
        And match response.message == 'Media eliminada exitosamente'


    Scenario: Delete media
        * def videoId = call read('upload.feature@UploadVideo')
        Given path 'upload/video/' + videoId.videoId
        And request { "token": "#(authToken)" }
        When method delete
        Then status 200
        And match response.message == 'Media eliminada exitosamente'
