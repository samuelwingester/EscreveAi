export class HeaderBase extends HTMLElement {
  connectedCallback() {
    this.innerHTML = `
          <div class="logos">
              <img src="../imgs/logos/logoL.png" alt="">
              <a href="home.html"><img src="../imgs/logos/logoH.png" alt=""></a>
          </div>
          <div class="professor">
              <h1>Professor <span class="nome-professor"></span></h1>
              <svg>
                <use href="../assets/icons/sprite.svg#icon-user"></use>
              </svg>
          </div>
      `;
  }
}

// customElements.define('header-padrao', HeaderPadrao);
