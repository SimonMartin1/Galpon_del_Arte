const form = $('#login-form');
const mensajeError = $('#msj-error');
const btnIngresar = $('#login-btn');

form.on('submit', async (e) => {
    e.preventDefault(); // 1. Evita que la página se recargue sola

    // Limpiamos errores previos y deshabilitamos botón (para evitar doble click)
    mensajeError.addClass('hide');
    btnIngresar.disabled = true;
    btnIngresar.text('Verificando...');

    // 2. Capturamos los datos
    const usuario = $('#log-user').val();
    const password = $('#log-pass').val();

    try {
        // 3. Enviamos la petición al Backend
        // Ajusta la ruta si tu archivo login.php está en otro lado
        const response = await fetch('/Galpon_del_Arte/admin/back/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Importante para que PHP entienda el JSON
            },
            body: JSON.stringify({ usuario, password })
        });

        // 4. Leemos la respuesta
        const data = await response.json();

        if (data.status === 'success') {
            // ¡LOGIN CORRECTO!
            // Redirigimos al panel principal
            window.location.href = 'selecDestacado.html'; 
        } else {
            // LOGIN INCORRECTO
            mostrarError(data.message || 'Error desconocido');
        }

    } catch (error) {
        console.error(error);
        mostrarError('Error de conexión con el servidor');
    } finally {
        // Pase lo que pase, reactivamos el botón
        btnIngresar.disabled = false;
        btnIngresar.text('Ingresar');
    }
});

function mostrarError(mensaje) {
    mensajeError.text(mensaje);
    mensajeError.removeClass('hide');
}