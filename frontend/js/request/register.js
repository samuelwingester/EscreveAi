import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";

const register_form = document.getElementById( "register-form" );

register_form.addEventListener( "submit", async function ( e )  {
  // Necessario formulario quebra sem essa função
  e.preventDefault()

  const formData = new FormData( register_form );

  const email = formData.get( "email" );
  const password = formData.get( "password" );
  const password_confirmation = formData.get( "password-confirmation" );

  const name = formData.get( "name" );
  const date = formData.get( "date" );
  let gender = formData.get( "gender" );

  if ( gender === "other" ) gender = null; // gambiarra rapida


  const remember = (formData.get( "remember" ) !== null);

  util.clearError();

  // Ta faltando verificação e coloque em funções pelo amor de deus
  // For fazer algo faz direito. se não souber todas as validações so me perguntar
  if (!email) {
      util.showError("Informe seu e-mail.");
      return;
  }

  if (!password) {
      util.showError("Informe sua senha.");
      return;
  }

  if (!password_confirmation) {
      util.showError("Confirme sua senha.");
      return;
  }

  if (password !== password_confirmation) {
      util.showError("As senhas não são iguais.");
      return;
  }

  if (!name) {
      util.showError("Informe seu nome.");
      return;
  }

  EscreveAiApi.fetch( "/register", "POST", {
    "email":email,
    "password":password,
    "password_confirmation":password_confirmation,
    "name":name,
    "gender":gender
  })
  .then( response => {
    if ( !response.ok ){
      return response.json().then( body => {
          const error = new Error("falha");
          error.status = response.status;
          error.data = body;
          throw error;
      });
    }
    return response.json();
  })
  .then( data => { // Cadastro bem sucedido

    EscreveAiApi.setTokenBearer( data["token"], remember );
    util.store( "username", data['user']['name'], remember );
    util.store( "remember", remember, remember ); //Verificar depois

    window.location.href = "./dashboard.html";
  })
  .catch( error => {
    let messages = "";

    if ( error.status === 422 ) { // Erros de vaildação do lado do servidor
      const data = error.data;
      for ( const field in data.errors ){
        data.errors[ field ].forEach( message => {
          messages += `<p>${message}</p>`;
        });
      }
    } else { messages = "Erro de rede"; console.log(error) }

    util.showError( messages );
  });
});
