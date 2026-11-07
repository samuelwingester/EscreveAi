import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";
import { buildErrorMessages, httpError } from "../helpers/errors.js";

const selectClassroomElement = document.getElementById( "select-turma-overlay" );
const classroomCardsContainer = document.getElementById( "classes-cards" );

const classroomFormElement = document.getElementById( "new-class-form" );
const classroomEditForm = document.getElementById( "edit-class-form" );

const classModal = document.getElementById( "new-class-modal" );
const classEditModal = document.getElementById( 'edit-class-modal' );

function loadClassroomCards(){
  function makeCards( data ){
    data.forEach( element => {
      const newCard = document.createElement( 'class-card' );
      let shift = element.shift;
      if ( !element.shift ) shift = '';

      newCard.name = element.name;
      newCard.shift = shift;
      newCard.classroom_id = element.id;

      //newCard.students = element.students; -> Reimplementar depois

      classroomCardsContainer.appendChild( newCard );
    })
  }

  classroomCardsContainer.innerHTML = '';
  EscreveAiApi.fetchWithAuth( '/classroom?columns=id,name,shift&order_by=created_at&limit=20&direction=desc' )
    .then( response => {
      if ( !response.ok ) throw httpError( response );
      return response.json();
    })
    .then( data => {
      if ( data === null ) throw Error("nenhuma turma encontrada");
      makeCards( data.data );
    })
    .catch( error => { console.log(error); } );
}

document.addEventListener("DOMContentLoaded", () => {
  loadClassroomCards();
});

selectClassroomElement.addEventListener( 'change', function () {
  base.buildClassName();
});

classroomFormElement.addEventListener( 'submit', function (e) {
  e.preventDefault();

  const formData = new FormData( classroomFormElement );

  const name = formData.get( 'name' );
  const shift = formData.get( 'shift' );

  util.clearError();
  // Adicionar escola depois implementação nmo back ja concluida
  EscreveAiApi.fetchWithAuth( '/classroom', 'POST', { 'name':name, 'shift':shift })
    .then( response => {
      if ( !response.ok ) {
        return response.json().then( body => {
          const error = new Error();
          error.status = response.status;
          error.data = body;
          throw error;
        });
      }
      classModal.close();
      loadClassroomCards();
      util.remove( 'list-classrooms' );
      base.BuildSelectClassroom();
    })
    .catch( error => {
      console.log( error );
      util.showError( buildErrorMessages( error ) );
    });
});

classroomEditForm.addEventListener( 'submit', function (e) {
  e.preventDefault();

  const formData = new FormData( classroomEditForm );

  const name = formData.get( 'name' );
  const shift = formData.get( 'shift' );
  const id = formData.get( 'id' );

  util.clearError();
  EscreveAiApi.fetchWithAuth( '/classroom/' + id, 'PUT', { 'name':name, 'shift':shift })
    .then( response => {
      if ( !response.ok ) {
        return response.json().then( body => {
          const error = new Error();
          error.status = response.status;
          error.data = body;
          throw error;
        });
      }
      classEditModal.close();
      loadClassroomCards();
      util.remove( 'list-classrooms' );
      base.BuildSelectClassroom();
    })
    .catch( error => {
      console.log( error );
      util.showError( buildErrorMessages( error ) );
    });
});

document.addEventListener( 'classroom-delete', function(e){
  const {id} = e.detail;

  EscreveAiApi.fetchWithAuth( '/classroom/' + id, "DELETE" )
    .then( response => {
      if ( !response.ok ) throw httpError( response );
      loadClassroomCards();
      util.remove( 'list-classrooms' );
      base.BuildSelectClassroom();
    })
    .catch( error => { console.log(error); } );
});

document.addEventListener( 'classroom-edit', function(e){
  const {id} = e.detail;

  const nameInput = document.getElementById( 'input-edit-name' );
  const shiftInput = document.getElementById( 'input-edit-shift' );

  document.getElementById( 'input-edit-id' ).value = id;

  EscreveAiApi.fetchWithAuth( '/classroom/' + id )
    .then( response => {
      if ( !response.ok ) throw httpError( response );
      return response.json();
    })
    .then( data => {
      data = data.classroom;
      nameInput.value = data.name;
      shiftInput.value = data.shift;
      classEditModal.showModal();
    })
    .catch( error => { console.log(error); } );
});
