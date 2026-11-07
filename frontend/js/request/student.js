import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";
import { buildErrorMessages, httpError } from "../helpers/errors.js";
import { fillSelect } from "../helpers/dom.js";
import { validateStudent } from "../helpers/validators.js";

const selectClassroomElement = document.getElementById( "select-turma-overlay" );

const studentDiv = document.getElementById( 'div-student-cards' );

const studentModalBtn = document.getElementById( 'student-modal-button' );
const studentModal = document.getElementById( 'new-student-modal' );
const studentEditModal = document.getElementById( 'edit-student-modal' );

const studentForm = document.getElementById( 'new-student-form' );
const studentEditForm = document.getElementById( 'edit-student-form' );

const selectClassroomFormElement = document.getElementById( 'input-form-class' );


async function loadStudents( id ) {
  EscreveAiApi.fetchWithAuth( '/classroom/' + id + '/student' )
    .then( response => {
      if ( !response.ok ) throw httpError( response );
      return response.json();
    })
    .then( data => {
      if ( data == null ) throw new Error();
      base.buildClassName();

      studentDiv.innerHTML = '';
      data['data'].forEach( student => {
        const newCard = document.createElement( 'student-card' );

        newCard.name = student.name;
        newCard.phase = student.writing_level;
        newCard.id = student.id;

        studentDiv.appendChild( newCard );
      });
    })
    .catch(error=>{console.log(error)});
}

selectClassroomElement.addEventListener( "change", function () {
  loadStudents( selectClassroomElement.value );
});

studentModalBtn.addEventListener( 'click', function () {
  const classrooms = util.retrieveJSON( "list-classrooms" );

  if ( !classrooms ) return;

  fillSelect( selectClassroomFormElement, classrooms );

  const selected = util.getSelectedClassroom();

  if ( !selected ) return; // nenhuma turma selecionada

  selectClassroomFormElement.value = selected.classroom_id;
  studentModal.showModal();
})

studentForm.addEventListener( 'submit', function ( e ) {
  e.preventDefault();

  const formData = new FormData( studentForm );

  const classroom = formData.get( 'classroom' );

  const name = formData.get( 'name' );
  const date = formData.get( 'birth-date' );
  const genre = formData.get( 'sexo' );
  const writing_level = formData.get( 'writing-level' );
  const observations = formData.get( 'observations' );

  util.clearFormError( studentForm );

  const errors = validateStudent( { classroom, name, date, genre, writing_level } );

  if ( errors.length ) {
    util.showFormError( studentForm, errors.map( message => `<p>${message}</p>` ).join( '' ) );
    return;
  }

  EscreveAiApi.fetchWithAuth( "/classroom/" + classroom + "/student", "POST", {
    "name":name, "birth_date":date, "genre":genre,
    "writing_level":writing_level, "observations":observations
  })
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
      studentModal.close();

      //Ineficiente mas suficiente por agora
      const event = new Event( 'change' );
      selectClassroomElement.dispatchEvent( event );
    })
    .catch( error => {
      console.log( error );
      util.showFormError( studentForm, buildErrorMessages( error ) );
    });
});

studentEditForm.addEventListener( 'submit', function (e){
  e.preventDefault();

  const formData = new FormData( studentEditForm );

  const idClass = selectClassroomElement.value;

  const name = formData.get( 'name' );
  const date = formData.get( 'birth-date' );
  const genre = formData.get( 'sexo' );
  const writing_level = formData.get( 'writing-level' );
  const observations = formData.get( 'observations' );
  const id = formData.get( 'id' );

  util.clearFormError( studentEditForm );

  const errors = validateStudent( { classroom: idClass, name, date, genre, writing_level } );

  if ( errors.length ) {
    util.showFormError( studentEditForm, errors.map( message => `<p>${message}</p>` ).join( '' ) );
    return;
  }

  EscreveAiApi.fetchWithAuth( "/classroom/" + idClass + "/student/" + id, "PUT", {
    "name":name, "birth_date":date, "genre":genre,
    "writing_level":writing_level, "observations":observations
  })
    .then( response => {
      if ( !response.ok ) {
        return response.json().then( body => {
          const error = new Error();
          error.status = response.status;
          error.data = body;
          throw error;
        });
      }
      studentEditModal.close();

      //Ineficiente mas suficiente por agora
      const event = new Event( 'change' );
      selectClassroomElement.dispatchEvent( event );
    })
    .catch( error => {
      console.log( error );
      util.showFormError( studentEditForm, buildErrorMessages( error ) );
    });
})

document.addEventListener( 'student-delete', function (e){
  const { id } = e.detail;
  const idClass = selectClassroomElement.value;

  EscreveAiApi.fetchWithAuth( '/classroom/' + idClass + "/student/" + id, "DELETE" )
    .then( response => {
      if ( !response.ok ) throw httpError( response );
      loadStudents( idClass );
    })
    .catch( error => { console.log(error); } );
});

document.addEventListener( 'student-edit', function (e){
  const { id } = e.detail;
  const idClass = selectClassroomElement.value;

  const nameInput = document.getElementById( 'input-edit-student-name' );
  const dateInput = document.getElementById( 'input-edit-birthdate' );
  const writingInput = document.getElementById( 'input-edit-writing-level' );
  const notesInput = document.getElementById( 'input-edit-notes' );

  document.getElementById( 'input-edit-id' ).value = id;

  EscreveAiApi.fetchWithAuth( '/classroom/' + idClass + "/student/" + id )
    .then( response => {
      if ( !response.ok ) throw httpError( response );
      return response.json();
    })
    .then( data => {
      data = data['student'];
      nameInput.value = data.name;
      dateInput.value = data.birth_date;
      writingInput.value = data.writing_level;
      notesInput.value = data.observations;

      if ( data.genre == 'man' ){ document.getElementById( 'input-edit-man' ).checked = true; }
      else if ( data.genre == 'woman' ){ document.getElementById( 'input-edit-woman' ).checked = true; }
      else { document.getElementById( 'input-edit-woman' ).checked = true; }

      studentEditModal.showModal();
    })
    .catch( error => { console.log(error); } );
});
