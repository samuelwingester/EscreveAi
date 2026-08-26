export class CommonField extends HTMLElement {
    connectedCallback() {
        const type = this.getAttribute('type') || 'text';
        const label = this.getAttribute('label') || '';
        const placeholder = this.getAttribute('placeholder') || '';
        const id = this.getAttribute('input_id') || '';
        const name = this.getAttribute('name') || id;
        const value = this.getAttribute('value') || '';
        const isSelect = this.getAttribute('is_select') === 'true';
        const size = this.getAttribute('size') || 'field'; // 'field' ou 'minifield'

        const options = this.innerHTML;
        const inputControl = isSelect
            ? `<select id="${id}" name="${name}"><option value="" disabled selected hidden>${placeholder}</option>${options}</select>`
            : `<input type="${type}" id="${id}" name="${name}" placeholder="${placeholder}" value="${value}">`;

        this.innerHTML = `
            <div class="${size}">
                ${label ? `<p class="title">${label}</p>` : ''}
                ${inputControl}
            </div>
        `;
    }
}
