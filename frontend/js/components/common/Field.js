export class CommonField extends HTMLElement {
    connectedCallback() {
        const type = this.getAttribute('type') || 'text';
        const label = this.getAttribute('label') || '';
        const placeholder = this.getAttribute('placeholder') || '';
        const id = this.getAttribute('input_id') || '';
        const name = this.getAttribute('name') || id;
        const value = this.getAttribute('value') || '';
        const isSelect = this.getAttribute('is_select') === 'true';
        const size = this.getAttribute('size') || 'field';
        const iconId = this.getAttribute('icon_id') || '';

        const iconTemplate = iconId ? `
            <svg class="input-icon">
                <use href="../assets/icons/sprite.svg#${iconId}"></use>
            </svg>
        ` : '';

        // Captura o HTML interno (options) antes de sobrescrever o innerHTML
        const optionsHTML = this.innerHTML.trim();

        const inputControl = isSelect
            ? `<select id="${id}" name="${name}">
                <option value="" disabled selected hidden>${placeholder}</option>
                ${optionsHTML}
               </select>`
            : `<input type="${type}" id="${id}" name="${name}" placeholder="${placeholder}" value="${value}">`;

        this.innerHTML = `
            <div class="${size}">
                ${label ? `<h3 class="title">${label}</h3>` : ''}
                <div class="input-wrapper ${iconId ? 'has-icon' : ''}">
                    ${iconTemplate}
                    ${inputControl}
                </div>
            </div>
        `;
    }
}
