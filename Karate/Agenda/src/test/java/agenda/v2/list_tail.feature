﻿Feature: List Tails

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'tail'
        When method GET
        Then status 200
        And match response.services contains ["Pequeña", "Normal", "Grande", "Gigante"]
