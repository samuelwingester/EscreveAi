import { EscreveAiApi } from "../../helpers/EscreveAiApi.js";

export class HeaderBase extends HTMLElement {
  connectedCallback() {
    this.innerHTML = `
          <div class="logos">
              <img src="../imgs/logos/logoL.png" alt="">
              <a href="home.html"><img src="../imgs/logos/logoH.png" alt=""></a>
          </div>
          <details class="icon">
            <summary>
              <div class="professor">
                  <h1>Professor <span class="nome-professor"></span></h1>
                    <svg>
                      <use href="../assets/icons/sprite.svg#icon-user"></use>
                    </svg>
              </div>
            </summary>
            <div class="dropdown">
              <button class="btn_option logout">
                <svg>
                    <use href="../assets/icons/sprite.svg#icon-logout"></use>
                </svg>
                <p>Sair da Conta</p>
              </button>
            </div>
          </details>
      `;

    this.querySelector('.logout').addEventListener('click', () => EscreveAiApi.logout());
  }

}

// customElements.define('home-header', HeaderPadrao);
