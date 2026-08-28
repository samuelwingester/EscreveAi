import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";

const selectClassroomElement = document.getElementById( "select-turma-overlay" );
const classroomCardsContainer = document.getElementById( "classes-cards" );
const classroomFormElement = document.getElementById( "new-class-form" );
const classModal = document.getElementById( 'class-modal' );

function loadClassroomCards(){
  function makeCards( data ){
    data.forEach( element => {
      const newCard = document.createElement( 'class-card' );
      let shift = element.shift;
      if ( !element.shift ) shift = '';

      newCard.name = element.name;
      newCard.shift = shift;
      newCard.id = element.id;

      newCard.students = element.students;

      classroomCardsContainer.appendChild( newCard );
    })
  }
  // Isso ta meio merda poderia aproveitar da requisição do base.js mas teria que mudar la e
  // nao vou fazer isso agora
  classroomCardsContainer.innerHTML = '';
  EscreveAiApi.fetchWithAuth( '/classroom' )
    .then( response => {
      if ( !response.ok ) throw new Error();
      return response.json();
    })
    .then( data => {
      if ( data === null ) throw Error("nenhuma turma encontrada");
      makeCards( data );
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
      let messages = "";

      if ( error.status === 422 ) { // Erros de validação do lado do servidor
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

document.addEventListener( 'classroom-delete', function(e){
  const {id} = e.detail;

  EscreveAiApi.fetchWithAuth( '/classroom/' + id, "DELETE" )
    .then( response => {
      if ( !response.ok ) throw response;
      loadClassroomCards();
      util.remove( 'list-classrooms' );
      base.BuildSelectClassroom();
    })
    .catch( error => { console.log(error); } );
});


base.BuildUserName();
base.BuildSelectClassroom();
