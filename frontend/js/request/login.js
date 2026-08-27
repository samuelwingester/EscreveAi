import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";

const login_form = document.getElementById( "login-form" );

login_form.addEventListener( "submit", function ( e )  {
  // Necessario formulario quebra sem essa função
  e.preventDefault();

  const formData = new FormData( login_form );

  const email = formData.get( "email" );
  const password = formData.get( "password" );
  const remember = (formData.get( "remember" ) !== null);

  util.clearError();

  // Validação ainda necessaria

  EscreveAiApi.fetch( "/login", "POST", { "email":email, "password":password } )
  .then( response => { // Verifica o status da requisição e monta o error para o catch
    if ( !response.ok ) {
      return response.json().then( body => {
        const error = new Error();
        error.status = response.status;
        error.data = body;
        throw error;
      });
    }

    return response.json();
  })
  .then( data => { // Requisição foi bem sucedida

    EscreveAiApi.setTokenBearer( data.token, remember );
    util.store( "username", data.user.name, remember );
    util.store( "remember", remember, remember ); //Verificar depois

    window.location.href = "./dashboard.html";
  })
  .catch( error => {
    let messages = "";

    // ruim melhorar depois
    if ( error.status === 401 ) {
      messages = ( "Credenciais Inválidas" );
    }
    else if ( error.status === 422 ) { // Erros de vaildação do lado do servidor
      const data = error.data;
      for ( const field in data.errors ){
        data.errors[ field ].forEach( message => {
          messages += `<p>${message}</p>`;
        });
      }
    } else { messages = "Erro de rede"; }

    util.showError( messages );
  });
});
