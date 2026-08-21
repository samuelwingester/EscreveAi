export class Base extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML;

        this.innerHTML = `
            <header-base></header-base>
            <main>
                <aside>
                    <div class="atual">
                        <p>TURMA ATUAL</p>
                        <div class="class">
                            <svg>
                                <use href="../assets/icons/sprite.svg#icon-users"></use>
                            </svg>
                            <h1>3º A</h1>
                        </div>
                        <button class="botao-largo">
                            <svg>
                                <use href="../assets/icons/sprite.svg#icon-switch"></use>
                            </svg>
                            <p>Trocar de Turma</p>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="menu">
                        <menu-option title="Turmas" icon="classes" stroke="2"></menu-option>
                        <menu-option title="Resumo" icon="dashboard" stroke="2"></menu-option>
                        <menu-option title="Alunos" icon="users" stroke="6"></menu-option>
                        <menu-option title="Atividades" icon="activities" stroke="2"></menu-option>
                        <menu-option title="Configurações" icon="gear" stroke="6"></menu-option>
                    </div>
                </aside>
                <div class="container">
                ${content}
                </div>
            </main>
            `;
    }
}