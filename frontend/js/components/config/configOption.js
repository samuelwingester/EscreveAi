export class ConfigOption extends HTMLElement {
    static observedAttributes = ['title', 'icon', 'stroke', 'subtitle', 'modal', 'id'];

    initialized = false;

    get title() { return this.getAttribute('title') || 'Opção'; }
    set title(value) { return this.setAttribute('title', value); }

    get icon() { return this.getAttribute('icon') || 'logout'; }
    set icon(value) { return this.setAttribute('icon', value); }

    get stroke() { return this.getAttribute('stroke') || '2'; }
    set stroke(value) { return this.setAttribute('stroke', value); }

    get subtitle() { return this.getAttribute('subtitle') || ''; }
    set subtitle(value) { return this.setAttribute('subtitle', value); }

    get modal() { return this.getAttribute('modal') || ''; }
    set modal(value) { return this.setAttribute('modal', value); }

    get id() { return this.getAttribute('id') || null; }
    set id(value) { return this.setAttribute('id', value); }

    connectedCallback() {
        this.render();
        this.initialized = true;
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (!this.initialized) return;
        if (oldValue === newValue) return;

        switch (name) {
            case 'title': this.renderTitle(); break;
            case 'icon': this.renderIcon(); break;
            case 'stroke': this.renderStroke(); break;
            case 'subtitle': this.renderSubtitle(); break;
            case 'modal': this.renderModal(); break;
        }
    }

    render() {
        this.innerHTML = `
            <div class="config-option" role="button" tabindex="0">
                <div class="left">
                    <div class="icon">
                        <svg>
                            <use href="../assets/icons/sprite.svg#icon-${this.icon}"></use>
                        </svg>
                    </div>
                    <div class="info">
                        <p><b></b></p>
                        <p class="disabled"></p>
                    </div>
                </div>
                <div class="modal-indicator">
                    <svg>
                        <use href="../assets/icons/sprite.svg#icon-dropdown-right"></use>
                    </svg>
                </div>
            </div>
        `;

        this.titleElement = this.querySelector('.info b');
        this.subtitleElement = this.querySelector('.info .disabled');
        this.iconUseElement = this.querySelector('.icon use');
        this.iconSvgElement = this.querySelector('.icon svg');
        this.modalElement = this.querySelector('.modal-indicator');

        this.renderTitle();
        this.renderSubtitle();
        this.renderIcon();
        this.renderStroke();
        this.renderModal();

        this.querySelector('.config-option').addEventListener('click', (event) => this.handleClick(event));
    }

    handleClick(event) {
        if (this.modal) {
            const targetModal = document.getElementById(`${this.modal}-modal`);
            if (targetModal && typeof targetModal.showModal === 'function') {
                targetModal.showModal();
            }
        }

        this.dispatchEvent(new CustomEvent('config-click', {
            bubbles: true,
            composed: true,
            detail: { id: this.id, modal: this.modal }
        }));
    }

    renderTitle() {
        if (this.titleElement) {
            this.titleElement.textContent = this.title;
        }
    }

    renderSubtitle() {
        if (this.subtitleElement) {
            this.subtitleElement.textContent = this.subtitle;
            this.subtitleElement.style.display = this.subtitle ? 'block' : 'none';
        }
    }

    renderIcon() {
        if (this.iconUseElement) {
            this.iconUseElement.setAttribute('href', `../assets/icons/sprite.svg#icon-${this.icon}`);
        }
    }

    renderStroke() {
        if (this.iconSvgElement) {
            this.iconSvgElement.style.strokeWidth = `${this.stroke}px`;
        }
    }

    renderModal() {
        if (this.modalElement) {
            this.modalElement.style.display = this.modal ? 'block' : 'none';
        }
    }
}