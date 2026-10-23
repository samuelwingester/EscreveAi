import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";

const selectClassroomElement = document.getElementById( "select-turma-overlay" );

const studentDiv = document.getElementById( 'div-student-cards' );

const studentModalBtn = document.getElementById( 'student-modal-button' );
const studentModal = document.getElementById( 'new-student-modal' );
const studentEditModal = document.getElementById( 'edit-student-modal' );

const studentForm = document.getElementById( 'new-student-form' );
const studentEditForm = document.getElementById( 'edit-student-form' );

const selectClassroomFormElement= document.getElementById( 'input-form-class' );


// Validações do lado do cliente (espelham as regras do backend)

const GENDERS = [ 'man', 'woman' ];
const WRITING_LEVELS = [ 'pre-silabico', 'silabico', 'silabico-alfabetico', 'alfabetico' ];

// Retorna a lista de mensagens de erro; lista vazia significa que está tudo certo.
function validateStudent( { classroom, name, date, genre, writing_level } ) {
  const errors = [];

  if ( !classroom ) errors.push( 'Informe a turma.' );

  const trimmedName = ( name ?? '' ).trim();
  if ( !trimmedName ) errors.push( 'Informe o nome.' );
  else if ( trimmedName.length > 150 ) errors.push( 'O nome deve ter no máximo 150 caracteres.' );

  if ( !date ) errors.push( 'Informe a data de nascimento.' );
  else {
    const birth = new Date( date + 'T00:00:00' );

    // O aluno precisa ter mais de 4 anos (o backend exige data anterior a hoje menos 4 anos)
    const limit = new Date();
    limit.setHours( 0, 0, 0, 0 );
    limit.setFullYear( limit.getFullYear() - 4 );

    if ( Number.isNaN( birth.getTime() ) ) errors.push( 'Data de nascimento inválida.' );
    else if ( birth >= limit ) errors.push( 'O aluno deve ter mais de 4 anos.' );
  }

  // Sexo "Outro" tem value vazio e o nível de escrita é opcional
  if ( genre && !GENDERS.includes( genre ) ) errors.push( 'Sexo inválido.' );
  if ( writing_level && !WRITING_LEVELS.includes( writing_level ) ) errors.push( 'Nível de escrita inválido.' );

  return errors;
}

// Mostra/limpa o erro no banner do próprio formulário (a página tem vários modais,
// então o util.showError, que usa o primeiro banner da página, não serve aqui).
function showFormError( form, html ) {
  const banner = form.querySelector( '.error-banner' );

  banner.innerHTML = html;
  banner.hidden = false;
}

function clearFormError( form ) {
  const banner = form.querySelector( '.error-banner' );

  banner.innerHTML = '';
  banner.hidden = true;
}


async function loadStudents( id ) {
  EscreveAiApi.fetchWithAuth( '/classroom/' + id + '/student' )
    .then( response => {
      if ( !response.ok ) throw new Error();
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

  selectClassroomFormElement.innerHTML = '';
  Object.entries( classrooms ).forEach( ([ id, name ]) => {
    const newOption = document.createElement( 'option' );

    newOption.textContent = name;
    newOption.value = id;

    selectClassroomFormElement.appendChild(newOption);
  })

  const selected = util.getSelectedClassroom();

  if ( !selected ) return; // nenhuma turma selecionada

  selectClassroomFormElement.value = selected.id;
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

  clearFormError( studentForm );

  const errors = validateStudent( { classroom, name, date, genre, writing_level } );

  if ( errors.length ) {
    showFormError( studentForm, errors.map( message => `<p>${message}</p>` ).join( '' ) );
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
      let messages = "";

      if ( error.status === 422 ) { // Erros de vaildação do lado do servidor
        const data = error.data;
        for ( const field in data.errors ){
          data.errors[ field ].forEach( message => {
            messages += `<p>${message}</p>`;
          });
        }
      } else {
        messages = "Erro de rede";
        console.log(error);
      }

      showFormError( studentForm, messages );
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

  clearFormError( studentEditForm );

  const errors = validateStudent( { classroom: idClass, name, date, genre, writing_level } );

  if ( errors.length ) {
    showFormError( studentEditForm, errors.map( message => `<p>${message}</p>` ).join( '' ) );
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
      let messages = "";

      if ( error.status === 422 ) { // Erros de vaildação do lado do servidor
        const data = error.data;
        for ( const field in data.errors ){
          data.errors[ field ].forEach( message => {
            messages += `<p>${message}</p>`;
          });
        }
      } else {
        messages = "Erro de rede";
        console.log(error);
      }

      showFormError( studentEditForm, messages );
    });
})

document.addEventListener( 'student-delete', function (e){
  const { id } = e.detail;
  const idClass = selectClassroomElement.value;

  EscreveAiApi.fetchWithAuth( '/classroom/' + idClass + "/student/" + id, "DELETE" )
    .then( response => {
      if ( !response.ok ) throw response;
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
      if ( !response.ok ) throw response;
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


base.BuildUserName();
base.BuildSelectClassroom();
