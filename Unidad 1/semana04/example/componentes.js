/**
 * La forma más moderna y recomendable de lograrlo es creando un Web Component. Esto te permite definir un elemento HTML reutilizable con su propio código y estilo.
 * 
 */

class FooterComponent extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.innerHTML = `
      <footer>
        <p>&copy; 2025 Mi Empresa. Todos los derechos reservados.</p>
        <p>Contáctanos en <a href="mailto:info@miempresa.com">info@miempresa.com</a></p>
      </footer>
    `;
  }
}

customElements.define('footer-component', FooterComponent);