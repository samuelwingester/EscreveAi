import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";

const selectClassroomElement = document.getElementById( "select-turma-overlay" );
const classroomElements = document.querySelectorAll( ".nome-turma" );
const alunosElement = document.getElementById( 'total-alunos' );

const ValueStatusElements = {
  'pre-silabico' : document.getElementById( 'pre-silabico' ),
  'silabico' : document.getElementById( 'silabico' ),
  'silabico-alfabetico' : document.getElementById( 'silabico-alfabetico' ),
  'alfabetico' : document.getElementById( 'alfabetico' ),
};

const NumberStatusElements = {
  'students' : document.getElementById( 'total-alunos-number' ),
  'activities' : document.getElementById( 'total-atividades-number' ),
  'reports' : document.getElementById( 'total-relatorios-number' )
}

function buildNumbers( data ){
  Object.entries( NumberStatusElements ).forEach( ([ key, element ]) => {
    element.title = data[key];
  });
}

function buildStatus( data, total ){
  Object.entries( ValueStatusElements ).forEach( ([ key, element ]) => {
    const percentage = ( data[key] / total ) / 100;
    element.value = data[key];
    element.percentage = percentage.toFixed(2);
  });
}

selectClassroomElement.addEventListener( "change", function () {
  const newClassId = selectClassroomElement.value;

  EscreveAiApi.fetchWithAuth( "/classroom/" + newClassId + "/stats" )
    .then( response => {
      if ( !response.ok ) throw Error();//tratar depois agora não e tão importante
      return response.json();
    })
    .then( data => {
      if ( data === null ) throw Error();
      return data;
    })
    .then( data => {
      classroomElements.forEach( element => element.textContent = data.name );

      alunosElement.textContent = data.total.students;

      buildNumbers( data.total );
      buildStatus( data.status );

      console.log(data)
    })
    .catch( error => {
      console.log(error);
    });
});
