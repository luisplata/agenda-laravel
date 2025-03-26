Feature: Subscription management

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Register a new Model user
        * def randomEmail = 'user' + Math.floor(Math.random() * 100000) + '@example.com'
        Given path 'register'
        And request { email: '#(randomEmail)', password: 'password123', role: 'Model' }
        When method post
        Then status 201
        And match response contains { email: '#(randomEmail)' }
        * def token = response.token

    Scenario: Login as Model
        Given path 'login'
        And request { email: '#(randomEmail)', password: 'password123' }
        When method post
        Then status 200
        * def authToken = response.token

    Scenario: Get user ID
        Given path 'me'
        And request { token: '#(authToken)' }
        When method get
        Then status 200
        * def userId = response.id

    Scenario: Create Person profile
        Given path 'persons'
        And request { name: 'Test Model', age: 25, user_id: '#(userId)', "token": '#(authToken)' }
        When method post
        Then status 201

    Scenario Outline: Add subscription to Model user
        Given path 'subscriptions', userId
        And request { months: <months>, "token": '#(authToken)' }
        When method post
        Then status 201
        And match response.subscription.expires_at == <expectedDate>

        Examples:
            | months | expectedDate |
            | 1      | '#(karate.get('todayPlus1Month'))' |
            | 2      | '#(karate.get('todayPlus2Months'))' |
            | 3      | '#(karate.get('todayPlus3Months'))' |
            | 4      | '#(karate.get('todayPlus4Months'))' |

    Scenario: Check expired subscriptions
        Given path 'subscriptions/check'
        When method get
        And request { "token": '#(authToken)' }
        Then status 200
        And match response.message == 'Verificación completada'
