document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {  // Retrasa la ejecución para asegurarse de que el footer está en el DOM
        const footer = document.querySelector("footer");
        if (footer) {
            console.log("Footer encontrado y ocultado.");
            footer.style.display = "none";
        } else {
            console.log("Footer no encontrado, intentando de nuevo...");
            setTimeout(arguments.callee, 500); // Sigue intentando hasta encontrarlo
        }
    }, 500);
});



