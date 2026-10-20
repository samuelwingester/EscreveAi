export class ConfigOption extends HTMLElement {
    connectedCallback() {
        const title = this.getAttribute('title') || 'Opção';
        const icon = this.getAttribute('icon') || 'logout';
        const stroke = this.getAttribute('stroke') || '2';
        const subtitle = this.getAttribute('subtitle') || '';
        this.innerHTML = `
            <div class="config-option">
                <div class="left">
                    <div class="icon">
                        <svg style="stroke-width: ${stroke}px;">
                            <use href="../assets/icons/sprite.svg#icon-${icon}"></use>
                        </svg>
                    </div>
                    <div class="info">
                        <p><b>${title}</b></p>
                        <p class="disabled">${subtitle}</p>
                    </div>
                </div>
                <svg>
                    <use href="../assets/icons/sprite.svg#icon-dropdown-right"></use>
                </svg>
            </div>
        `;

    }
}