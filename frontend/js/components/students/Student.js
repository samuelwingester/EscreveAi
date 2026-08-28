export class Student extends HTMLElement {
  static observedAttributes = [ 'name', 'phase', 'last-activity' ];

  initialized = false;

  get name(){ return this.getAttribute( 'name' ) || ''; }
  set name( value ){ return this.setAttribute( 'name', value ); }

  get phase(){ return this.getAttribute( 'phase' ) || 'Não informada'; }
  set phase( value ){ return this.setAttribute( 'phase', value ); }

  get last_activity(){ return this.getAttribute( 'last-activity' ) || 'Sem registros'; }
  set last_activity( value ){ return this.setAttribute( 'last-activity', value ); }

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
                  <div class="image">
                  </div>
                  <div class="status">
                      <p class="title"></p>
                      <div class="phase"><p class="text-phase"></p></div>
                      <div class="last">
                          <p>Última Atividade:</p>
                          <p class="text-last-activity" ></p>
                      </div>
                  </div>
              </div>
              <div class="tools">
                  <div class="report">
                      <svg>
                          <use href="../assets/icons/sprite.svg#icon-document"></use>
                      </svg>
                      <p>Ver Relatório</p>
                  </div>
                  <div class="line"></div>
                  <div class="edit">
                      <svg>
                          <use href="../assets/icons/sprite.svg#icon-pencil"></use>
                      </svg>
                      <p>Editar</p>
                  </div>
              </div>
          </div>
      `;

<<<<<<< HEAD
        this.innerHTML = `
            <div class="card">
                <div class="student">
                    <div class="image">
                    </div>
                    <div class="status">
                        <p class="title">${name}</p>
                        <div class="phase"><p>${phase}</p></div>
                        <div class="last">
                            <p>Última Atividade:</p>
                            <p>${lastActivity}</p>
                        </div>
                    </div>
                </div>
                <div class="tools">
                    <div class="report">
                        <svg>
                            <use href="../assets/icons/sprite.svg#icon-document"></use>
                        </svg>
                        <p>Ver Relatório</p>
                    </div>
                    <div class="line"></div>
                    <details class="menu">
                        <summary>
                            <svg>
                                <use href="../assets/icons/sprite.svg#icon-menu"></use>
                            </svg>
                        </summary>
                        <div class="dropdown">
                            <button type="button" class="btn_option edit">
                                <svg>
                                    <use href="../assets/icons/sprite.svg#icon-pencil"></use>
                                </svg>
                                <span>Editar</span>
                            </button>

                            <div class="line"></div>

                            <button type="button" class="btn_option delete">
                                <svg>
                                    <use href="../assets/icons/sprite.svg#icon-delete"></use>
                                </svg>
                                <span>Excluir</span>
                            </button>
                        </div>
                    </details>
                </div>
            </div>
        `;
=======
      this.nameElement = this.querySelector( '.title' );
      this.phaseElement = this.querySelector( '.text-phase' );
      this.lastActivityElement = this.querySelector( '.text-last-activity' );
>>>>>>> d935c45490cab19062bba792449719affe88732d

      this.renderName();
      this.renderPhase();
      this.renderLastActivity();

      /*
      const btnReport = this.querySelector('.btn-report');
      if (btnReport) {
          btnReport.addEventListener('click', () => {
              window.location.href = `relatorio.html?aluno=${encodeURIComponent(name)}`;
          });
      }

      const btnEdit = this.querySelector('.btn-edit');
      if (btnEdit) {
          btnEdit.addEventListener('click', () => {
              const modal = document.getElementById('edit-student-modal');
              if (modal) modal.showModal();
          });
      }
      */
  }

  renderName(){ this.nameElement.textContent = this.name; }
  renderPhase(){ this.phaseElement.textContent = this.phase; }
  renderLastActivity(){ this.lastActivityElement.textContent = this.last_activity; }
}

