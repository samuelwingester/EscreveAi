export class Activity extends HTMLElement {
  static observedAttributes = [
    'activity_id', 'title', 'description', 'file-count', 'date', 'img-src',
  ];

  initialized = false;

  get activity_id() { return this.getAttribute('activity_id') || ''; }
  set activity_id(value) { this.setAttribute('activity_id', value); }

  get title() { return this.getAttribute('title') || 'Nome da Atividade'; }
  set title(value) { this.setAttribute('title', value); }

  get description() { return this.getAttribute('description') || 'Descrição da atividade...'; }
  set description(value) { this.setAttribute('description', value); }

  get fileCount() { return this.getAttribute('file-count') || '0'; }
  set fileCount(value) { this.setAttribute('file-count', value); }

  get date() { return this.getAttribute('date') || 'Data indisponível'; }
  set date(value) { this.setAttribute('date', value); }

  get imgSrc() { return this.getAttribute('img-src') || ''; }
  set imgSrc(value) { this.setAttribute('img-src', value); }

  connectedCallback() {
    this.render();
    this.initialized = true;
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (!this.initialized) return;
    if (oldValue === newValue) return;

    switch (name) {
      case 'title': this.renderTitle(); break;
      case 'description': this.renderDescription(); break;
      case 'file-count': this.renderfileCount(); break;
      case 'date': this.renderDate(); break;
      case 'img-src': this.renderImage(); break;
    }
  }

  render() {
    this.innerHTML = `
      <div class="activity">
        <div class="info">
          <div class="image"></div>
          <div class="desc">
            <p class="title activity-title"></p>
            <p class="placeholder activity-description"></p>
            <div class="file-count">
              <svg aria-hidden="true">
                <use href="../assets/icons/sprite.svg#icon-image"></use>
              </svg>
              <p><span class="file-count-value"></span> imagens</p>
            </div>
          </div>
        </div>

        <div class="tools">
          <div class="date">
            <svg aria-hidden="true">
              <use href="../assets/icons/sprite.svg#icon-calendar"></use>
            </svg>
            <p class="activity-date"></p>
          </div>
          <div class="buttons">
            <button type="button" class="botao-largo btn-view">
              <svg aria-hidden="true">
                <use href="../assets/icons/sprite.svg#icon-eye"></use>
              </svg>
              <span class="purple">Ver Detalhes</span>
            </button>
            <button type="button" class="botao-largo btn-edit">
              <svg aria-hidden="true">
                <use href="../assets/icons/sprite.svg#icon-pencil"></use>
              </svg>
              <span class="purple">Editar</span>
            </button>
          </div>
        </div>
      </div>
    `;

    this.imageElement = this.querySelector('.image');
    this.titleElement = this.querySelector('.activity-title');
    this.descriptionElement = this.querySelector('.activity-description');
    this.fileCountElement = this.querySelector('.file-count-value');
    this.dateElement = this.querySelector('.activity-date');

    this.renderImage();
    this.renderTitle();
    this.renderDescription();
    this.renderfileCount();
    this.renderDate();

    this.querySelector('.btn-view').addEventListener('click', () => this.view());
    this.querySelector('.btn-edit').addEventListener('click', () => this.edit());
  }

  view() {
    this.dispatchEvent(new CustomEvent('activity-view', {
      bubbles: true, composed: true, detail: { id: this.activity_id },
    }));
  }

  edit() {
    this.dispatchEvent(new CustomEvent('activity-edit', {
      bubbles: true, composed: true, detail: { id: this.activity_id },
    }));
  }

  renderImage() {
    this.imageElement.style.backgroundImage = this.imgSrc
      ? `url(${JSON.stringify(this.imgSrc)})`
      : '';
  }

  renderTitle() { this.titleElement.textContent = this.title; }
  renderDescription() { this.descriptionElement.textContent = this.description; }
  renderfileCount() { this.fileCountElement.textContent = this.fileCount; }
  renderDate() { this.dateElement.textContent = this.date; }
}
