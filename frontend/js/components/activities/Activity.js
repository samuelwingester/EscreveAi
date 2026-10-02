export class Activity extends HTMLElement {
  connectedCallback() {
    const title = this.getAttribute('title') || 'Nome da Atividade';
    const description = this.getAttribute('description') || 'Descrição da atividade...';
    const imgCount = this.getAttribute('img-count') || 0;
    const date = this.getAttribute('date') || 'Data indisponível';
    const imgSrc = this.getAttribute('img-src') || '';

    this.innerHTML = `
      <div class="activity">
        <div class="info">
          <div class="image" ${imgSrc ? `style="background-image: url('${imgSrc}');"` : ''}></div>
          <div class="desc">
            <p class="title">${title}</p>
            <p class="placeholder">${description}</p>
            <div class="img-count">
              <svg>
                <use href="../assets/icons/sprite.svg#icon-image"></use>
              </svg>
              <p>${imgCount} imagens</p>
            </div>
          </div>
        </div>

        <div class="tools">
          <div class="date">
            <svg>
              <use href="../assets/icons/sprite.svg#icon-calendar"></use>
            </svg>
            <p>${date}</p>
          </div>
          <div class="buttons">
            <button class="botao-largo">
              <svg>
                <use href="../assets/icons/sprite.svg#icon-eye"></use>
              </svg>
              <p class="purple">Ver Detalhes</p>
            </button>
            <button class="botao-largo">
              <svg>
                <use href="../assets/icons/sprite.svg#icon-pencil"></use>
              </svg>
              <p class="purple">Editar</p>
            </button>
          </div>
        </div>
      </div>
    `;
  }
}