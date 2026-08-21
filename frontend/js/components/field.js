export class Field extends HTMLElement {
  connectedCallback() {
    const type = this.getAttribute('type') || 'text';
    const icon = this.getAttribute('icon') || 'user';
    const placeholder = this.getAttribute('placeholder') || 'Selecione...';
    const stroke = this.getAttribute('stroke') || '1';
    const hasEye = this.getAttribute('eye') === 'true';
    const id = this.getAttribute('input_id') || '';
    const name = this.getAttribute('name') || id;
    const isSelect = this.getAttribute('is_select') === 'true';

    const options = this.innerHTML;
    const inputControl = isSelect
      ? `<select id="${id}" name="${name}" required><option value="" disabled selected hidden>${placeholder}</option>${options}</select>`
      : `<input type="${type}" placeholder="${placeholder}" id="${id}" name="${name}" required>`;
    
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
              <span class="toggle-eye" style="cursor: pointer;">
                <svg class="eye-icon" style="stroke-width: 2px;">
                  <use href="../assets/icons/spffffrite.svg#icon-eye"></use>
                </svg>
              </span>
            ` : ''}
          </div>
        </div>
      `;

    if (hasEye && !isSelect) {
      const input = this.querySelector('input');
      const use = this.querySelector('.eye-icon use');

      this.querySelector('.toggle-eye').onclick = () => {
        const isPass = input.type === 'password';
        input.type = isPass ? 'text' : 'password';
        use.setAttribute('href', `../assets/icons/sprite.svg#icon-eye${isPass ? '-off' : ''}`);
      };
    }
  }
}