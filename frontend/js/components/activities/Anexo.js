export class Anexo extends HTMLElement {
  static observedAttributes = [
    'anexo_id', 'filename', 'type', 'url'
  ];

  get anexo_id() { return this.getAttribute('anexo_id') || ''; }
  set anexo_id(value) { this.setAttribute('anexo_id', value); }

  get filename() { return this.getAttribute('filename') || 'None'; }
  set filename(value) { this.setAttribute('filename', value); }

  get type() { return this.getAttribute('type') || 'local'; }
  set type(value) { this.setAttribute('type', value); }

  get url() { return this.getAttribute('url') || ''; }
  set url(value) { this.setAttribute('url', value); }

  connectedCallback() {
    this.render();
    this.bindEvents();
  }

  render() {
    this.innerHTML = `
      <div class="anexo-container">
        <p class="filename-p"></p>

        <button type="button" class="btn-download"
                aria-label="Baixar anexo">
          <svg aria-hidden="true">
            <use href="../assets/icons/sprite.svg#icon-download"></use>
          </svg>
        </button>

        <button type="button" class="btn-view"
                aria-label="Visualizar anexo">
          <svg aria-hidden="true">
            <use href="../assets/icons/sprite.svg#icon-eye"></use>
          </svg>
        </button>

        <button type="button" class="btn-delete"
                aria-label="Excluir anexo">
          <svg aria-hidden="true">
            <use href="../assets/icons/sprite.svg#icon-delete"></use>
          </svg>
        </button>
      </div>
    `;

    this.querySelector('.filename-p').textContent = this.filename;
  }

  bindEvents() {
    this.querySelector('.btn-download').addEventListener('click', () => {
      this.dispatchAnexoEvent('anexo-download');
    });

    this.querySelector('.btn-view').addEventListener('click', () => {
      this.dispatchAnexoEvent('anexo-view');
    });

    this.querySelector('.btn-delete').addEventListener('click', () => {
      this.dispatchAnexoEvent('anexo-delete');
    });
  }

  dispatchAnexoEvent(eventName) {
    this.dispatchEvent(new CustomEvent(eventName, {
      bubbles: true,
      composed: true,
      detail: {
        id: this.anexo_id,
        filename: this.filename,
        type: this.type,
        url: this.url
      }
    }));
  }
}

