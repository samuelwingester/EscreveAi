export class Value extends HTMLElement {
    connectedCallback() {
        const color = this.getAttribute('color') || 'purple';
        const percentage = this.getAttribute('percentage') || 1;
        const total = this.getAttribute('total') || 1;
        const categoria = this.innerHTML.trim();
        
        this.innerHTML = `
        <div class="value">
            <div class="category">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="5" cy="5" r="5" fill="var(--${color})" />
                </svg>
                <p>${categoria}</p>
            </div>
            <div class="max" style="background-color: var(--${color}-soft)">
                <div class="real" style="width: ${percentage}%; background-color: var(--${color}-dark)"></div>
            </div>
            <div class="numbers">
                <p>${total} alunos</p>
                <p class="placeholder">(${percentage}%)</p>
            </div>
        </div>
      `;
    }
}