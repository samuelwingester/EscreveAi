export class Base extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML;
        const activeRoute = this.getAttribute('active') || '';
        this.innerHTML = `
            <header-base></header-base>
            <main>
                <aside>
                    <div class="atual">
                        <div class="class">
                            <svg><use href="../assets/icons/sprite.svg#icon-users"></use></svg>

                            <h1 class="turma-titulo" id="turma-titulo"></h1>
                        </div>

                        <div class="trocar-turma-wrapper">
                            <button type="button" class="botao-largo">
                                <svg><use href="../assets/icons/sprite.svg#icon-switch"></use></svg>
                                <p>Trocar de Turma</p>
                            </button>


                            <select id="select-turma-overlay" onchange="atualizarTurmas(this.value)">
                                <option value="" disabled selected hidden></option>
                            </select>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="menu">
                        <menu-option title="Turmas" icon="classes" stroke="2" route="classes" ${activeRoute === 'classes' ? 'active' : ''}></menu-option>
                        <menu-option title="Resumo" icon="dashboard" stroke="2" route="dashboard" ${activeRoute === 'dashboard' ? 'active' : ''}></menu-option>
                        <menu-option title="Alunos" icon="users" stroke="6" route="students" ${activeRoute === 'students' ? 'active' : ''}></menu-option>
                        <menu-option title="Atividades" icon="activities" stroke="2" route="activities" ${activeRoute === 'activities' ? 'active' : ''}></menu-option>
                        <menu-option title="Configurações" icon="gear" stroke="6" route="config" ${activeRoute === 'config' ? 'active' : ''}></menu-option>
                    </div>
                </aside>
                <div class="container">
                ${content}
                </div>
            </main>
            `;


    }
}

window.atualizarTurmas = function(novaTurma) {
    if (!novaTurma) return;
    const elementosTurma = document.querySelectorAll('.turma-titulo');
    elementosTurma.forEach(elemento => {
        elemento.textContent = novaTurma;
    });
};
