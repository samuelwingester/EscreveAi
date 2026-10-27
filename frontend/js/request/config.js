import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";

const DeleteForm = document.getElementById( 'delete-user-form' );
const ChangePasswordForm = document.getElementById( 'change-password-form' )
const EditForm = document.getElementById( 'edit-user-form' );

DeleteForm.addEventListener( 'submit', function ( e ) {
  e.preventDefault();

  EscreveAiApi.fetchWithAuth( '/user', 'DELETE' )
    .then( response => {
      if ( !response.ok ) {
        throw response;
      }
      localStorage.clear();
      sessionStorage.clear();
      window.location.href = "./home.html";
    })
    .catch( error => { console.log( error ) } );
});

EditForm.addEventListener( 'submit', function ( e ) {
  e.preventDefault();

  const data = new FormData( EditForm );

  EscreveAiApi.fetchWithAuth( '/user', 'put', data )
    .then( response => {
      if ( !response.ok ) throw response;
      utils.remove('username');
      base.BuildUserName();
    })
    .catch( error => { console.log(error); } );
});

ChangePasswordForm.addEventListener( 'submit', function ( e ) {
  e.preventDefault();

  const data = new FormData( ChangePasswordForm );

  EscreveAiApi.fetchWithAuth( '/change_password', 'PUT', data )
    .then( response => {
       if ( !response.ok ) { console.log( response ); }
    })
});

base.BuildUserName();
base.BuildSelectClassroom();
