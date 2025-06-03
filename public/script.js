let map;
let marker;

function guardarUbicacion() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const { latitude, longitude } = position.coords;
            localStorage.setItem("ubicacionGuardada", JSON.stringify({ latitude, longitude }));
            alert("Ubicación guardada.");

            obtenerCiudadDesdeCoords(latitude, longitude, (ciudad) => {
                if (ciudad) {
                    mostrarCiudadEnMapa(ciudad);
                }
                enviarUbicacionAlServidor(latitude, longitude, ciudad);
            });
        }, (error) => {
            alert("Error al obtener la ubicación: " + error.message);
        });
    } else {
        alert("Tu navegador no soporta geolocalización.");
    }
}

function mostrarCiudadEnMapa(ciudad) {
    if (!ciudad) {
        alert("No se pudo determinar la ciudad.");
        return;
    }

    const url = `https://nominatim.openstreetmap.org/search?city=${encodeURIComponent(ciudad)}&format=json&limit=1`;

    fetch(url, {
        headers: {
            "User-Agent": "TuAppEjemplo/1.0 (tu@email.com)"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.length === 0) {
            alert("No se encontró la ciudad en el mapa.");
            return;
        }

        const { lat, lon } = data[0];

        if (!map) {
            map = L.map('map').setView([lat, lon], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(map);
        } else {
            map.setView([lat, lon], 12);
        }

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lon]).addTo(map).bindPopup(`Ciudad: ${ciudad}`).openPopup();
    })
    .catch(err => {
        console.error("Error buscando ciudad:", err);
        alert("Error al mostrar la ciudad en el mapa.");
    });
}

function obtenerCiudadDesdeCoords(lat, lon, callback = null) {
    const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`;

    fetch(url, {
        headers: {
            "User-Agent": "TuAppEjemplo/1.0 (tu@email.com)"
        }
    })
    .then(res => res.json())
    .then(data => {
        const direccion = data.address;
        const ciudad = direccion.city || direccion.town || direccion.village || direccion.state;
        if (callback) callback(ciudad);
    })
    .catch(err => {
        console.error("Error obteniendo ciudad:", err);
        if (callback) callback(null);
    });
}

function enviarUbicacionAlServidor(latitude, longitude, ciudad = null) {
    const token = document.getElementById("tokenInput").value.trim();

    if (!token) {
        alert("Por favor, ingresa un token antes de enviar la ubicación.");
        return;
    }

    fetch("/api/ubicaciones", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            latitud: latitude,
            longitud: longitude,
            ciudad: ciudad,
            token: token
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Ubicación guardada en servidor:", data);
        alert("Ubicación enviada al servidor.");
    })
    .catch(error => {
        console.error("Error al enviar ubicación:", error);
        alert("Error al guardar en servidor.");
    });
}

function cargarUltimaUbicacionDesdeServidor() {
    const token = document.getElementById("tokenInput").value.trim();

    if (!token) {
        alert("Por favor, ingresa un token antes de cargar la ubicación.");
        return;
    }

    fetch(`/api/ubicacion?token=${encodeURIComponent(token)}`)
    .then(res => {
        if (!res.ok) {
            throw new Error("No se pudo obtener la ubicación.");
        }
        return res.json();
    })
    .then(data => {
        if (!data.ciudad) {
            alert("La ciudad obtenida es inválida.");
            return;
        }

        mostrarCiudadEnMapa(data.ciudad);
        alert("Ubicación cargada del servidor.");
    })
    .catch(err => {
        console.error("Error al cargar ubicación:", err);
        alert("Error al obtener la última ubicación.");
    });
}

function buscarUsuariosCerca(kilometros) {
    if (!navigator.geolocation) {
        alert("Tu navegador no soporta geolocalización.");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const token = document.getElementById("tokenInput").value.trim();

            if (!token) {
                alert("Por favor, ingresa un token antes de buscar usuarios cerca.");
                return;
            }

            const url = `/api/usuarios-cerca?latitud=${lat}&longitud=${lon}&kilometros=${kilometros}&token=${encodeURIComponent(token)}`;

            fetch(url, {
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json",
                }
            })
            .then(res => {
                if (!res.ok) throw new Error("Error al obtener usuarios cercanos.");
                return res.json();
            })
            .then(data => {
                console.log("Usuarios cerca:", data);
                alert(`Se encontraron ${data.length} usuarios dentro de ${kilometros} km.`);
                // Aquí puedes manejar la UI con esos datos
            })
            .catch(err => {
                console.error(err);
                alert("No se pudo obtener los usuarios cercanos.");
            });
        },
        (error) => {
            alert("No se pudo obtener tu ubicación: " + error.message);
        }
    );
}

document.addEventListener("DOMContentLoaded", () => {
    // Al cargar la página, intenta mostrar la ciudad guardada o cargar la última del servidor
    const ubicacion = JSON.parse(localStorage.getItem("ubicacionGuardada"));
    if (ubicacion) {
        obtenerCiudadDesdeCoords(ubicacion.latitude, ubicacion.longitude, (ciudad) => {
            if (ciudad) {
                mostrarCiudadEnMapa(ciudad);
            }
        });
    } else {
        cargarUltimaUbicacionDesdeServidor();
    }
});
