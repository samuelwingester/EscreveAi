export class Field extends HTMLElement {
  connectedCallback() {
    const type = this.getAttribute('type') || 'text';
    const icon = this.getAttribute('icon') || 'user';
    const placeholder = this.getAttribute('placeholder') || 'Selecione...';
    const stroke = this.getAttribute('stroke') || 1;
    const hasEye = this.getAttribute('eye') === 'true';
    const id = this.getAttribute('input_id') || '';
    const isSelect = this.getAttribute('is_select') === 'true';

    let inputControl = '';

    if (isSelect) {
      const optionsHTML = this.innerHTML.trim();
      inputControl = `
        <select id="${id}">
          <option value="" disabled selected hidden>${placeholder}</option>
          ${optionsHTML}
        </select>
      `;
    } else {
      inputControl = `<input type="${type}" placeholder="${placeholder}" id="${id}">`;
    }

    this.innerHTML = `
      <div class="field">
        <div class="icon">
          <svg style="stroke-width: ${stroke}px;">
            <use href="../assets/icons/sprite.svg#icon-${icon}"></use>
          </svg>
        </div>
        <div class="text">
          ${inputControl}
          ${hasEye ? `
            <label class="toggle-eye" style="cursor: pointer;">
              <svg class="eye-icon" style="stroke-width: 2px;">
                <use href="../assets/icons/sprite.svg#icon-eye"></use>
              </svg>
            </label>
          ` : ''}
        </div>
      </div>
    `;

    if (hasEye) {
      const input = this.querySelector('input');
      const useTag = this.querySelector('.eye-icon use');

      this.querySelector('.toggle-eye').addEventListener('click', () => {
        const isOriginal = input.type === type;
        input.type = isOriginal ? 'text' : type;
        useTag?.setAttribute('href', `../assets/icons/sprite.svg#icon-eye${isOriginal ? '-off' : ''}`);
      });
    }
  }
}