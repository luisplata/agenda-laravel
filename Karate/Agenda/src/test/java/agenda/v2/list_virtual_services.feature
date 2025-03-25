Feature: List Tails

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of services
        Given path 'biotype'
        When method GET
        Then status 200
        And match response.services contains ["Creadora de contenido", "Videollamadas", "Novia virtual", "Videos personalizados", "Pack de Fotos", "Pack de Videos pregrabados", "Foto Zing", "Gif Zing", "Dickrate", "Sexting", "Chat Hot", "Canal VIP Telegram", "Venta de ropa interior", "Servicios personalizados", "Otros, a consultar"]
