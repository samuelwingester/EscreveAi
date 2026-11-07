import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import { buildErrorMessages } from "../helpers/errors.js";
import { validateRegister } from "../helpers/validators.js";

const register_form = document.getElementById( "register-form" );

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
    console.log( error );
    util.showError( buildErrorMessages( error ) );
  });
});
