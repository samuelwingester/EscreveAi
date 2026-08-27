export class MenuOption extends HTMLElement {
    connectedCallback() {
        const icon = this.getAttribute('icon') || 'classes';
        const title = this.getAttribute('title') || 'Turmas';
        const route = this.getAttribute('route') || 'base'
        const stroke = this.getAttribute('stroke') || 2;
        const isActive = this.hasAttribute('active');

        this.innerHTML = `
            <a href="${route.toLowerCase()}.html" class="menu-link">
                <div class="option ${isActive ? 'active' : ''}">
                    <svg style="stroke-width: ${stroke}px;">
                        <use href="../assets/icons/sprite.svg#icon-${icon}"></use>
                    </svg>
                    <p>${title}</p>
                </div>
            </a>
        `;
    }
}