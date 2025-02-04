Feature: Upload API

    Background:
        * url 'http://127.0.0.1:8000/api'
        * def token = call read('login.feature@login_success') { email: 'test@example.com', password: 'password' }

    @UploadImage
    Scenario: Upload an image
        * def personId = call read('person.feature@createPerson')
        Given path 'upload/image/' + personId.personId
        And multipart file file = { read: 'classpath:sampleImage.jpg', filename: 'sampleImage.jpg', contentType: 'image/jpeg' }
        And multipart field token = token.tokenAuth
        When method post
        Then status 201
        And match response.message == 'Imagen subida exitosamente'
        * def imagenId = response.media.id

    @UploadVideo
    Scenario: Upload a video
        * def personId = call read('person.feature@createPerson')
        Given path 'upload/video/' + personId.personId
        And multipart file file = { read: 'classpath:sampleVideo.mp4', filename: 'sampleVideo.mp4', contentType: 'video/mp4' }
        And multipart field token = token.tokenAuth
        When method post
        Then status 201
        And match response.message == 'Video subido exitosamente'
        * def videoId = response.media.id

    Scenario: Delete media
        * def imagenId = call read('upload.feature@UploadImage')
        Given path 'upload/image/' + imagenId.imagenId
        And request { "token": #(token.tokenAuth) }
        When method delete
        Then status 200
        And match response.message == 'Media eliminada exitosamente'


    Scenario: Delete media
        * def videoId = call read('upload.feature@UploadVideo')
        Given path 'upload/video/' + videoId.videoId
        And request { "token": #(token.tokenAuth) }
        When method delete
        Then status 200
        And match response.message == 'Media eliminada exitosamente'
