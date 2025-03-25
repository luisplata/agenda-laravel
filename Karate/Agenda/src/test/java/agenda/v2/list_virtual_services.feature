Feature: List virtualServices

    Background:
        * url 'https://back.agenda.peryloth.com/api'

    Scenario: Retrieve list of virtualServices
        Given path 'virtualServices'
        When method GET
        Then status 200
        And match response.virtual_services contains ["Creadora de contenido", "Videollamadas", "Novia virtual", "Videos personalizados", "Pack de Fotos", "Pack de Videos pregrabados", "Foto Zing", "Gif Zing", "Dickrate", "Sexting", "Chat Hot", "Canal VIP Telegram", "Venta de ropa", "Servicios personalizados", "Otros, a consultar"]
