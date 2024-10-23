// Validación del formulario de contacto
document.getElementById('contact-form').addEventListener('submit', function(event) {
    let nombre = document.getElementById('nombre').value;
    let email = document.getElementById('email').value;
    let mensaje = document.getElementById('mensaje').value;
    
    if (nombre === '' || email === '' || mensaje === '') {
        alert('Todos los campos son obligatorios');
        event.preventDefault();
    } else if (!validateEmail(email)) {
        alert('Por favor, introduce un correo válido');
        event.preventDefault();
    }
});

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\\.,;:\s@"]+\.)+[^<>()[\]\\.,;:\s@"]{2,}))$/i;
    return re.test(String(email).toLowerCase());
}
