export class Class extends HTMLElement {
    connectedCallback() {
        const color = this.getAttribute('color') || 'purple';
        const name = this.getAttribute('name') || 'Turma Sem Nome';
        const students = this.getAttribute('students') || '0';
        const shift = this.getAttribute('shift') || 'Turno não informado';

        this.innerHTML = `
            <div class="class" style="--card-color: var(--${color});">
                <div class="top" style="background-color:var(--${color}-dark)">
                    <svg viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="5" cy="5" r="5" fill="var(--${color})" />
                    </svg>
                    <h3>${name}</h3>
                </div>
                <div class="data">
                    <div class="students">
                        <svg>
                            <use href="../assets/icons/sprite.svg#icon-users"></use>
                        </svg>
                        <p>${students} Alunos</p>
                    </div>
                    <div class="shift">
                        <svg>
                            <use href="../assets/icons/sprite.svg#icon-calendar"></use>
                        </svg>
                        <p>${shift}</p>
                    </div>
                </div>
                <div class="join" style="background-color:var(--${color}-dark)">
                    <button type="button" class="btn-entrar">
                        <p class="title">Entrar</p>
                    </button>
                </div>
            </div>
        `;

        const btnEntrar = this.querySelector('.btn-entrar');
        if (btnEntrar) {
            btnEntrar.addEventListener('click', () => {
                localStorage.setItem('turmaAtual', name);
                window.location.href = 'dashboard.html';
            });
        }
    }
}