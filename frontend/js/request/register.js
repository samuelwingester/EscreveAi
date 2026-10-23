import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";

const register_form = document.getElementById( "register-form" );


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


// lista de mensagens de erro lisa vazia está tudo certo!
function validateRegister( { name, email, password, password_confirmation, gender } ) {
  const errors = [];

  const trimmedName = ( name ?? "" ).trim();
  if ( !trimmedName ) errors.push( "Informe o nome." );
  else if ( trimmedName.length > 150 ) errors.push( "O nome deve ter no máximo 150 caracteres." );

  const trimmedEmail = ( email ?? "" ).trim();
  if ( !trimmedEmail ) errors.push( "Informe o e-mail." );
  else if ( !isValidEmail( trimmedEmail ) ) errors.push( "E-mail inválido." );

  if ( !password ) errors.push( "Informe a senha." );
  else if ( password.length < 8 ) errors.push( "A senha deve ter no mínimo 8 caracteres." );

  if ( password !== password_confirmation ) errors.push( "As senhas não conferem." );

  // "other" virou null no submit, so vai validar chegou algum valor
  if ( gender && ![ "man", "woman" ].includes( gender ) ) errors.push( "Gênero inválido." );

  return errors;
}

register_form.addEventListener( "submit", async function ( e )  {
 
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

  const errors = validateRegister( { name, email, password, password_confirmation, gender } );

  if ( errors.length ) {
    util.showError( errors.map( message => `<p>${message}</p>` ).join( "" ) );
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
  .then( data => { 

    EscreveAiApi.setTokenBearer( data.token, remember );
    util.store( "username", data.user.name, remember );
    util.store( "remember", remember, remember ); //Verificar depois

    window.location.href = "./dashboard.html";
  })
  .catch( error => {
    let messages = "";

    if ( error.status === 422 ) { // Erros servidor
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