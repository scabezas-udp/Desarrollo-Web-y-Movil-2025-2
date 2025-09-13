getFooterHTML();

function getFooterHTML() {
    const objeto = document.getElementById('footer');
    objeto.innerHTML = `
        <p>&copy; 2025 Mi Empresa. Todos los derechos reservados.</p>
        <p>Contáctanos en <a href="mailto:info@miempresa.com">info@miempresa.com</a></p>
    `;
}