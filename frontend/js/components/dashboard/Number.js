export class Number extends HTMLElement {
  static observedAttributes = [ 'value', 'description', 'color' ];

  initialized = false;

  get value(){ return this.getAttribute( 'value' ) || 0; }
  set value( value ){ this.setAttribute( 'value', value ); }

  get description(){ return this.getAttribute( 'description' ) || '' }
  set description( description ){ this.setAttribute( 'description', description ); }

  get color(){ return this.getAttribute( 'color' ) || 'blue'; }
  set color( color ){ return this.setAttribute( 'color', color ); }

  connectedCallback() { this.render(); this.initialized = true; }

  attributeChangedCallback( name, oldValue, newValue ){
    if ( !this.initialized ) return;
    if ( oldValue === newValue ) return;

    switch ( name ) {
      case 'value': this.renderValue(); break;
      case 'description': this.renderDescription(); break;
      case 'color':  this.renderColor(); break;
    }
  }

  render() {
    this.innerHTML = `
      <div class="number">
        <div class="container">
          <h1></h1>
          <p class="title"></p>
        </div>
      </div>
    `;

    this.containerElement = this.querySelector('.container');
    this.valueElement = this.querySelector('h1');
    this.descriptionElement = this.querySelector('.title');

    this.renderValue();
    this.renderDescription();
    this.renderColor();
  }

  renderValue() { this.valueElement.textContent = this.value; }
  renderDescription() { this.descriptionElement.textContent = this.description; }
  renderColor() {
    this.containerElement.style.backgroundColor = `var(--${this.color}-soft)`;
    this.valueElement.style.color = `var(--${this.color})`;
  }
}
