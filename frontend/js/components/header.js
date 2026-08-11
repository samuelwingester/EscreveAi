export class HeaderPadrao extends HTMLElement {
    connectedCallback() {   
      this.innerHTML = `
          <div class="logos">
              <img src="../../imgs/logos/logoL.png" alt="">
              <img src="../../imgs/logos/logoH.png" alt="">
          </div>
          <div class="botoes">
              <button class="botao-padrao" id= "vazio">
                  <p><a href="login.html">Entrar</a></p>
              </button>
              <button class="botao-padrao">
                  <p><a href="register.html">Criar Conta</a></p>
              </button>
          </div>
      `;
    }
  }

// customElements.define('header-padrao', HeaderPadrao);