Feature: Auth API

    Background:
        * url 'https://backend.newpage.peryloth.com/api'
        * def loginResponse = call read('login.feature@login_success') { email: 'test@example.com', password: 'password' }
        * def tokenAuth = loginResponse.tokenAuth

    Scenario: Get user details
        Given path 'me'
        * request { token: #(tokenAuth) }
        When method get
        Then status 200
        And match response.email == 'test@example.com'

    Scenario: Logout
        Given path 'logout'
        * request { token: #(tokenAuth) }
        When method post
        Then status 200
        And match response.message == 'Sesión cerrada'
