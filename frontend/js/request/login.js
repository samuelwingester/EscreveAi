import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import { buildErrorMessages } from "../helpers/errors.js";
import { validateLogin } from "../helpers/validators.js";

const login_form = document.getElementById( "login-form" );

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
    console.log( error );
    util.showError( buildErrorMessages( error ) );
  });
});
