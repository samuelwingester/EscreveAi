import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";

const login_form = document.getElementById( "login-form" );


function isValidEmail( email ) {
  if ( email.includes( " " ) ) return false;

  const parts = email.split( "@" );
  if ( parts.length !== 2 ) return false;

  const [ user, domain ] = parts;
  if ( !user ) return false;

  const domainParts = domain.split( "." );
  if ( domainParts.length < 2 ) return false;
  if ( domainParts.some( part => !part ) ) return false;

  return true;
}


function validateLogin( { email, password } ) {
  const errors = [];

  const trimmedEmail = ( email ?? "" ).trim();
  if ( !trimmedEmail ) errors.push( "Informe o e-mail." );
  else if ( !isValidEmail( trimmedEmail ) ) errors.push( "E-mail inválido." );

  // No login só exige que a senha esteja preenchida o tamanho mínimo
  if ( !password ) errors.push( "Informe a senha." );

  return errors;
}

login_form.addEventListener( "submit", function ( e )  {
  e.preventDefault();

  const formData = new FormData( login_form );

  const email = formData.get( "email" );
  const password = formData.get( "password" );
  const remember = (formData.get( "remember" ) !== null);

  util.clearError();

  const errors = validateLogin( { email, password } );

  if ( errors.length ) {
    util.showError( errors.map( message => `<p>${message}</p>` ).join( "" ) );
    return;
  }

  EscreveAiApi.fetch( "/login", "POST", { "email":email, "password":password } )
  .then( response => {
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
  .then( data => {

    EscreveAiApi.setTokenBearer( data.token, remember );
    util.store( "username", data.user.name, remember );
    util.store( "remember", remember, remember ); //isso e engraçado

    window.location.href = "./dashboard.html";
  })
  .catch( error => {
    let messages = "";

    // ruim melhorar depois
    if ( error.status === 401 ) {
      messages = ( "Credenciais Inválidas" );
    }
    else if ( error.status === 422 ) {
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
