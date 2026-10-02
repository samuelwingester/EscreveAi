export class Value extends HTMLElement {
  static observedAttributes = [ 'color', 'percentage', 'total', 'categoria' ];

  initialized = false;

  get color() { return this.getAttribute( 'color' ) || 'purple'; }
  set color( value ) { this.setAttribute( 'color', value ); }

  get percentage() { return Number( this.getAttribute( 'percentage' ) || 0 ); }
  set percentage( value ) { this.setAttribute( 'percentage', value ); }

  get total() { return Number( this.getAttribute( 'total' ) || 0 ); }
  set total( value ) { this.setAttribute( 'total', value ); }

  get categoria() { return this.getAttribute( 'categoria' ) || ''; }
  set categoria( value ) { this.setAttribute( 'categoria', value ); }

  connectedCallback() { this.render(); this.initialized = true; }

  attributeChangedCallback( name, oldValue, newValue ) {
    if ( !this.initialized ) return;
    if ( oldValue === newValue ) return;

    switch ( name ) {
      case 'color': this.renderColor(); break;
      case 'percentage': this.renderPercentage(); break;
      case 'total': this.renderTotal(); break;
      case 'categoria': this.renderCategoria(); break;
    }
  }

  render() {
    this.innerHTML = `
      <div class="value">
        <div class="category">
          <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
            <circle cx="5" cy="5" r="5"></circle>
          </svg>
          <p class="category-text"></p>
        </div>

        <div class="max">
          <div class="real"></div>
        </div>

        <div class="numbers">
          <p class="total"></p>
          <p class="placeholder"></p>
        </div>
      </div>
    `;

    this.circleElement = this.querySelector( 'circle' );
    this.categoryElement = this.querySelector( '.category-text' );
    this.maxElement = this.querySelector( '.max' );
    this.realElement = this.querySelector( '.real' );
    this.totalElement = this.querySelector( '.total' );
    this.percentageElement = this.querySelector( '.placeholder' );

    this.renderColor();
    this.renderCategoria();
    this.renderPercentage();
    this.renderTotal();
  }

  renderColor() {
    this.circleElement.setAttribute( 'fill', `var(--${this.color})` );
    this.maxElement.style.backgroundColor = `var(--${this.color}-soft)`;
    this.realElement.style.backgroundColor = `var(--${this.color}-dark)`;
  }

  renderPercentage() {
    this.realElement.style.width = `${this.percentage}%`;
    this.percentageElement.textContent = `(${this.percentage}%)`;
  }

  renderCategoria() { this.categoryElement.textContent = this.categoria; }
  renderTotal() { this.totalElement.textContent = `${this.total} alunos`; }
}
