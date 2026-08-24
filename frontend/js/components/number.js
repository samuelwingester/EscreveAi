export class Number extends HTMLElement {
    connectedCallback() {
        const title = this.getAttribute('title') || 24;
        const description = this.getAttribute('description') || 'Alunos';
        const color = this.getAttribute('color') || 'blue'
        this.innerHTML = `
        <div class="number">
            <div class="container" style="background-color: var(--${color}-soft);">
                <h1 style="color: var(--${color});">${title}</h1>
                <p class="title">${description}</p>
             </div>
        </div>
      `;
    }
}

// customElements.define('my-benefit', Benefit);