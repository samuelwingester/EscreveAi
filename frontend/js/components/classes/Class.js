export class Class extends HTMLElement {
  static observedAttributes = [ 'color', 'name', 'students', 'shift' ];

  initialized = false;

  get color() { return this.getAttribute('color') || 'purple'; }
  set color(value) { this.setAttribute('color', value); }

  get name() { return this.getAttribute('name') || 'Turma Sem Nome'; }
  set name(value) { this.setAttribute('name', value); }

  get students() { return this.getAttribute('students') || '0'; }
  set students(value) { this.setAttribute('students', value); }

  get shift() { return this.getAttribute('shift') || 'Turno não informado'; }
  set shift(value) { this.setAttribute('shift', value); }

  connectedCallback(){ this.render(); this.initialized = true; }

  attributeChangedCallback( name, oldValue, newValue ){
    if ( !this.initialized ) return;
    if ( oldValue === newValue ) return;

    switch( name ){
      case 'name': this.renderName(); break;
      case 'students': this.renderStudents(); break;
      case 'shift': this.renderShift(); break;
    }
  }

  render(){
    this.innerHTML = `
      <div class="class" style="--card-color: var(--${this.color}); border: solid 1px var(--${this.color}-dark);">
        <div class="top" style="background-color:var(--${this.color}-dark)">
            <svg viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="5" cy="5" r="5" fill="var(--${this.color})" />
            </svg>
            <h3 class="class-name"></h3>
        </div>
        <div class="data">
          <div class="students">
            <svg>
              <use href="../assets/icons/sprite.svg#icon-users"></use>
            </svg>
            <p><span class="student-count"></span> Alunos</p>
          </div>
          <div class="shift">
            <svg>
              <use href="../assets/icons/sprite.svg#icon-calendar"></use>
            </svg>
            <p class="shift-name"></p>
          </div>
        </div>
        <div class="join" style="background-color:var(--${this.color}-dark)">
          <button type="button" class="btn-entrar">
            <p class="title">Entrar</p>
          </button>
        </div>
      </div>
    `;

    this.nameElement = this.querySelector( '.class-name' );
    this.studentsElement = this.querySelector( '.student-count' );
    this.shiftElement = this.querySelector( '.shift-name' );

    this.renderName();
    this.renderStudents();
    this.renderShift();
  }

  renderName(){ this.nameElement.textContent = this.name; }
  renderStudents(){ this.studentsElement.textContent = this.students }
  renderShift(){ this.shiftElement.textContent = this.shift }
}
