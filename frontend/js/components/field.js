export class Field extends HTMLElement {
  connectedCallback() {
    const icon = this.getAttribute('icon') || 'user';
    const placeholder = this.getAttribute('placeholder') || 'Placeholder padrão';
    const stroke = this.getAttribute('stroke') || 1;
    const eye = this.getAttribute('eye') === 'true';
    const input_id = this.getAttribute('input_id') || '';

    const inputType = eye ? 'password' : 'text';
    const display = eye ? 'block' : 'none';

    this.innerHTML = `
      <div class="field">
        <div class="icon">
          <svg style="stroke-width: ${stroke}px;">
            <use href="../../assets/icons/sprite.svg#icon-${icon}"></use>
          </svg>
        </div>
        <div class="text">
          <input type="${inputType}" placeholder="${placeholder}" id="${input_id}">
          <label class="toggle-eye" style="display: ${display}; cursor: pointer;">
            <svg class="eye-icon" style="stroke-width: 2px;">
              <use href="../../assets/icons/sprite.svg#icon-eye"></use>
            </svg>
          </label>
        </div>
      </div>
    `;

    // Se o olho estiver habilitado, adiciona a lógica de clique
    if (eye) {
      this.setupEyeToggle();
    }
  }

  setupEyeToggle() {
    const input = this.querySelector('input');
    const eyeBtn = this.querySelector('.toggle-eye');
    const eyeUseTag = this.querySelector('.eye-icon use');

    eyeBtn.addEventListener('click', () => {
      const isPassword = input.type === 'password';
      
      input.type = isPassword ? 'text' : 'password';
      if (eyeUseTag) {
        const iconName = isPassword ? 'icon-eye-off' : 'icon-eye';
        eyeUseTag.setAttribute('href', `../../assets/icons/sprite.svg#${iconName}`);
      }
    });
  }
}

// customElements.define('my-field', Field);