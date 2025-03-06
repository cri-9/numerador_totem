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
	const texto = "Número " + numeroAPalabras(numero);

	if ('speechSynthesis' in window) {
		const utterance = new SpeechSynthesisUtterance(texto);
		const voces = speechSynthesis.getVoices();
		const vozEnEspanol = voces.find(voz => voz.lang === 'es-ES') || voces[0]; // Usar la primera voz disponible si no hay en español
		utterance.voice = vozEnEspanol;
		utterance.lang = vozEnEspanol.lang; // Configurar el idioma de la voz
		utterance.onstart = () => console.log("Comenzó a anunciar el número"); // Depuración
		utterance.onend = () => console.log("Finalizó el anuncio"); // Depuración
		speechSynthesis.speak(utterance); // Anunciar el número
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
			if (response.success) {
				const numeroActual = response.numero;

				// Actualizar el número en la pantalla
				$('#numeroActual').text(numeroActual);

				// Anunciar el número si cambió
				if (numeroActual !== numeroAnterior) {
					repetirAnuncio(numeroActual, 2, 3200); // Repetir 3 veces con 4 segundos de retraso
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
	// Activar pantalla completa automáticamente al cargar la página
	document.documentElement.requestFullscreen();
});
