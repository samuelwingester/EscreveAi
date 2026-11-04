export class Student extends HTMLElement {
  static observedAttributes = [ 'name', 'phase', 'last-activity' ];

  initialized = false;

  get name(){ return this.getAttribute( 'name' ) || ''; }
  set name( value ){ return this.setAttribute( 'name', value ); }

  get phase(){ return this.getAttribute( 'phase' ) || 'Não informada'; }
  set phase( value ){ return this.setAttribute( 'phase', value ); }

  get last_activity(){ return this.getAttribute( 'last-activity' ) || 'Sem registros'; }
  set last_activity( value ){ return this.setAttribute( 'last-activity', value ); }

  get id() { return this.getAttribute('id') || null; }
  set id(value) { return this.setAttribute('id', value); }

  connectedCallback(){ this.render(); this.initialized = true; }

  attributeChangedCallback( name, oldValue, newValue ){
    if ( !this.initialized ) return;
    if ( oldValue === newValue ) return;

    switch( name ){
      case 'name': this.renderName(); break;
      case 'phase': this.renderPhase(); break;
      case 'last-activity': this.renderLastActivity(); break;
    }
  }

  render(){
      this.innerHTML = `
        <div class="card">
            <div class="student">
              <div class="image"></div>
              <div class="status">
                <p class="title"></p>
                <div class="phase"><p class="text-phase"></p></div>
                <div class="last">
                  <p>Última Atividade:</p>
                  <p class="text-last-activity"></p>
                </div>
              </div>
            </div>
            <div class="tools">
                <a href="studentActivities.html">
                <button type="button" class="btn-action view-activities">
                    <svg>
                        <use href="../assets/icons/sprite.svg#icon-eye"></use>
                    </svg>
                    <span>Ver Atividades</span>
                </button>
                </a>
                <button type="button" class="btn-action edit">
                    <svg>
                        <use href="../assets/icons/sprite.svg#icon-pencil"></use>
                    </svg>
                    <span>Editar</span>
                </button>

                <button type="button" class="btn-action delete">
                    <svg>
                        <use href="../assets/icons/sprite.svg#icon-delete"></use>
                    </svg>
                    <span>Excluir</span>
                </button>
            </div>
          </div>
      `;

      this.nameElement = this.querySelector( '.title' );
      this.phaseElement = this.querySelector( '.text-phase' );
      this.lastActivityElement = this.querySelector( '.text-last-activity' );

      this.renderName();
      this.renderPhase();
      this.renderLastActivity();

      this.querySelector( '.view-activities' ).addEventListener( 'click', () => this.viewActivities() );
      this.querySelector( '.edit' ).addEventListener( 'click', () => this.edit() );
      this.querySelector( '.delete' ).addEventListener( 'click' , () => this.delete() );
  }

  viewActivities() {
    this.dispatchEvent(new CustomEvent('student-view-activities', { bubbles: true, composed: true, detail: { id: this.id } }));
  }

  edit() {
    this.dispatchEvent(new CustomEvent('student-edit', { bubbles: true, composed: true, detail: { id: this.id } }));
  }

  delete() {
    this.dispatchEvent(new CustomEvent('student-delete', { bubbles: true, composed: true, detail: { id: this.id } }));
  }

  renderName(){ this.nameElement.textContent = this.name; }
  renderPhase(){ this.phaseElement.textContent = this.phase; }
  renderLastActivity(){ this.lastActivityElement.textContent = this.last_activity; }
}