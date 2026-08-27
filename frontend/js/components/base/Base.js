export class Base extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML;
        const activeRoute = this.getAttribute('active') || '';

        this.innerHTML = `
            <base-header></base-header>
            <main>
                <aside>
                    <div class="atual">
                        <div class="class">
                            <svg><use href="../assets/icons/sprite.svg#icon-users"></use></svg>
                            <h1 class="turma-titulo" id="turma-titulo">3º A</h1>
                        </div>

                        <div class="trocar-turma-wrapper">
                            <button type="button" class="botao-largo">
                                <svg><use href="../assets/icons/sprite.svg#icon-switch"></use></svg>
                                <p>Trocar de Turma</p>
                            </button>

                            <select id="select-turma-overlay">
                                <option value="" disabled selected hidden></option>
                            </select>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="menu">
                        <base-menu-option title="Turmas" icon="classes" stroke="2" route="classes" ${activeRoute === 'classes' ? 'active' : ''}></base-menu-option>
                        <base-menu-option title="Resumo" icon="dashboard" stroke="2" route="dashboard" ${activeRoute === 'dashboard' ? 'active' : ''}></base-menu-option>
                        <base-menu-option title="Alunos" icon="users" stroke="6" route="students" ${activeRoute === 'students' ? 'active' : ''}></base-menu-option>
                        <base-menu-option title="Atividades" icon="activities" stroke="2" route="activities" ${activeRoute === 'activities' ? 'active' : ''}></base-menu-option>
                        <base-menu-option title="Configurações" icon="gear" stroke="6" route="config" ${activeRoute === 'config' ? 'active' : ''}></base-menu-option>
                    </div>
                </aside>
                <div class="container">
                    ${content}
                </div>
            </main>
        `;

        const select = this.querySelector('#select-turma-overlay');
        const aplicarTurma = (nomeTurma) => {
            localStorage.setItem('turmaAtual', nomeTurma);
            document.querySelectorAll('.turma-titulo').forEach(el => el.textContent = nomeTurma);
            if (select) select.value = nomeTurma;
        };
        const turmaSalva = localStorage.getItem('turmaAtual') || '3º A';
        aplicarTurma(turmaSalva);

        if (select) {
            select.addEventListener('change', (e) => aplicarTurma(e.target.value));
        }
    }

    sincronizarTurma() {
        const turmaSalva = localStorage.getItem('turmaAtual');
        if (!turmaSalva) return;

        document.querySelectorAll('.turma-titulo').forEach(el => {
            el.textContent = turmaSalva;
        });
    }
}
