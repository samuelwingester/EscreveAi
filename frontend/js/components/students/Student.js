export class Student extends HTMLElement {
    connectedCallback() {
        this.render();

        const observer = new MutationObserver(() => this.render());
        observer.observe(this, { attributes: true });
    }

    render() {
        const name = this.getAttribute('name') || 'Nome do Aluno';
        const phase = this.getAttribute('phase') || 'Não informada';
        const lastActivity = this.getAttribute('last-activity') || 'Sem registros';

        this.innerHTML = `
            <div class="card">
                <div class="student">
                    <div class="image">
                    </div>
                    <div class="status">
                        <p class="title">${name}</p>
                        <div class="phase"><p>${phase}</p></div>
                        <div class="last">
                            <p>Última Atividade:</p>
                            <p>${lastActivity}</p>
                        </div>
                    </div>
                </div>
                <div class="tools">
                    <div class="report">
                        <svg>
                            <use href="../assets/icons/sprite.svg#icon-document"></use>
                        </svg>
                        <p>Ver Relatório</p>
                    </div>
                    <div class="line"></div>
                    <details class="menu">
                        <summary>
                            <svg>
                                <use href="../assets/icons/sprite.svg#icon-menu"></use>
                            </svg>
                        </summary>
                        <div class="dropdown">
                            <button type="button" class="btn_option edit">
                                <svg>
                                    <use href="../assets/icons/sprite.svg#icon-pencil"></use>
                                </svg>
                                <span>Editar</span>
                            </button>

                            <div class="line"></div>

                            <button type="button" class="btn_option delete">
                                <svg>
                                    <use href="../assets/icons/sprite.svg#icon-delete"></use>
                                </svg>
                                <span>Excluir</span>
                            </button>
                        </div>
                    </details>
                </div>
            </div>
        `;

        const btnReport = this.querySelector('.btn-report');
        if (btnReport) {
            btnReport.addEventListener('click', () => {
                window.location.href = `relatorio.html?aluno=${encodeURIComponent(name)}`;
            });
        }

        const btnEdit = this.querySelector('.btn-edit');
        if (btnEdit) {
            btnEdit.addEventListener('click', () => {
                const modal = document.getElementById('edit-student-modal');
                if (modal) modal.showModal();
            });
        }
    }
}

