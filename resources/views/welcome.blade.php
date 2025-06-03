<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ubicación con Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 15px;
        }

        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 0 10px;
        }

        button {
            margin: 5px 0;
            padding: 8px 12px;
            cursor: pointer;
        }

        input[type="text"],
        input[type="number"] {
            padding: 6px 8px;
            margin-top: 3px;
            width: 100%;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <h1>Ubicación con Leaflet y OSM</h1>

    <label for="tokenInput">Token Bearer:</label>
    <input type="text" id="tokenInput" placeholder="Escribe tu token aquí" />

    <button onclick="guardarUbicacion()">Guardar ubicación</button>
    <button onclick="cargarUltimaUbicacionDesdeServidor()">Cargar última ubicación desde servidor</button>

    <label for="kmInput">Buscar usuarios en un radio de (km):</label>
    <input type="number" id="kmInput" min="0" step="0.1" placeholder="Ej. 5" />
    <button onclick="buscarUsuariosCerca(parseFloat(document.getElementById('kmInput').value))">
        Buscar usuarios cerca
    </button>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="script.js"></script>
</body>

</html>