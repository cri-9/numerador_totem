let numeroAnterior = 0; // Variable para almacenar el número anterior

// Función para convertir un número en palabras (en español)
function numeroAPalabras(numero) {
    const unidades = [
        "cero", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"
    ];
    const decenas = [
        "", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"
    ];
    const especiales = [
        "diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"
    ];

    if (numero < 10) {
        return unidades[numero];
    } else if (numero >= 10 && numero < 20) {
        return especiales[numero - 10];
    } else if (numero >= 20 && numero < 100) {
        const decena = Math.floor(numero / 10);
        const unidad = numero % 10;
        return decenas[decena] + (unidad !== 0 ? " y " + unidades[unidad] : "");
    } else if (numero >= 100) {
        return "número " + numero; // Para números mayores a 100, simplemente decimos "número X"
    }
}

// Función para anunciar el número en voz alta
function anunciarNumero(numero) {
    if ('speechSynthesis' in window) {
        if (numero) {
            try {
                speechSynthesis.onvoiceschanged = function() {
                    const voces = speechSynthesis.getVoices();
                    let vozEnEspanol = voces.find(voz => voz.lang === 'es-ES');

                    // Verificar si se encontró una voz en español
                    if (typeof vozEnEspanol !== "undefined") {
                        const texto = "Número " + numero;
                        const utterance = new SpeechSynthesisUtterance(texto);
                        utterance.voice = vozEnEspanol;
                        utterance.lang = vozEnEspanol.lang;
                        utterance.onstart = () => console.log("Comenzó a anunciar el número");
                        utterance.onend = () => console.log("Finalizó el anuncio");
                        speechSynthesis.speak(utterance);
                    } else {
                        // Solución alternativa: usar la primera voz disponible o mostrar un mensaje de error
                        if (voces.length > 0) {
                            const texto = "Número " + numero;
                            const utterance = new SpeechSynthesisUtterance(texto);
                            utterance.voice = voces[0]; // Usar la primera voz disponible
                            utterance.lang = voces[0].lang;
                            utterance.onstart = () => console.log("Comenzó a anunciar el número (voz alternativa)");
                            utterance.onend = () => console.log("Finalizó el anuncio (voz alternativa)");
                            speechSynthesis.speak(utterance);
                        } else {
                            console.error("No se encontraron voces disponibles.");
                        }
                    }
                };
            } catch (error) {
                console.error("Error al anunciar el número:", error);
            }
        } else {
            console.error("Número indefinido para la función anunciarNumero.");
        }
    } else {
        console.error("La Web Speech API no está soportada en este navegador.");
    }
}
function repetirAnuncio(numero, repeticiones, retraso) {
    let contador = 0;
    const intervalo = setInterval(() => {
        anunciarNumero(numero);
        contador++;
        if (contador >= repeticiones) {
            clearInterval(intervalo);
        }
    }, retraso);
}

function actualizarNumero() {
    $.ajax({
        url: 'backend/obtener_numero.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("Respuesta AJAX (actualizarNumero):", response);
            if (response.success && response.numero) {
                const numeroActual = response.numero;

                // Actualizar el número en la pantalla
                $('#numeroActual').text(numeroActual);

                // Anunciar el número si cambió
                if (numeroActual !== numeroAnterior) {
                    repetirAnuncio(numeroActual, 2, 3200); // Repetir 2 veces con 3.2 segundos de retraso
                    numeroAnterior = numeroActual; // Actualizar el número anterior
                }
            } else {
                console.error('Error: ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX: ' + error);
        }
    });
}

function actualizarFechaHora() {
    const ahora = new Date();
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    const fechaHora = ahora.toLocaleDateString('es-ES', opciones);
    $('#fechaHora').text(fechaHora);
}

$(document).ready(function() {
    setInterval(actualizarNumero, 1000); // Actualizar cada segundo
    actualizarFechaHora(); // Actualizar al cargar la página
    setInterval(actualizarFechaHora, 1000); // Actualizar cada segundo

    // Activar pantalla completa al hacer clic en el botón
    $('#btnPantallaCompleta').pointerdown(function(event) {
        event.stopPropagation();
		setTimeout(function() {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        }, 0);
    });
});