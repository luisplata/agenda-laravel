Feature: List Payment Methods

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of payment methods
        Given path 'payment_methods_list'
        When method GET
        Then status 200
        And match response[0].name == "paypal"
        And match response[0].icon == "paypal"
        And match response[1].name == "binance"
        And match response[1].icon == "binance_icon"
        And match response[2].name == "other_bank"
        And match response[2].icon == "more_icons_to_bank"
