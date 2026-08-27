import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";

const selectClassroomElement = document.getElementById( "select-turma-overlay" );
const studentDiv = document.getElementById( 'div-student-cards' );

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
      data.forEach( student => {
        const newCard = document.createElement( 'student-card' );

        newCard.name = student.name;
        newCard.phase = student.writing_level;

        studentDiv.appendChild( newCard );
      });
    });
}

selectClassroomElement.addEventListener( "change", function () {
  loadStudents( selectClassroomElement.value );
});

base.BuildUserName();
base.BuildSelectClassroom();
