export class MenuOption extends HTMLElement {
    connectedCallback() {
        const icon = this.getAttribute('icon') || 'classes';
        const title = this.getAttribute('title') || 'Turmas';
        const stroke = this.getAttribute('stroke') || 2;
        this.innerHTML = `
            <div class="option">
                <svg style='stroke-width:${stroke}px'>
                    <use href="../assets/icons/sprite.svg#icon-${icon}"></use>
                </svg>
                <p>${title}</p>
            </div>
        `;
    }
}