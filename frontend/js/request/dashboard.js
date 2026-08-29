import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";

const selectClassroomElement = document.getElementById( "select-turma-overlay" );
const classroomElements = document.querySelectorAll( ".turma-titulo" );
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
    element.value = data[key];
  });
}

function buildStatus( data, total ){
  Object.entries( ValueStatusElements ).forEach( ([ key, element ]) => {
    let percentage = 0;
    if ( data[key] !== 0 ) percentage = ( data[key] / total ) * 100;
    element.total = data[key];
    element.percentage = percentage.toFixed(2);
  });
}

function loadClassroomStats( value ){
  EscreveAiApi.fetchWithAuth( "/classroom/" + value + "/stats" )
    .then( response => { if ( !response.ok ) throw Error(); return response.json(); })
    .then( data => { if ( data === null ) throw Error(); return data; })
    .then( data => {
      alunosElement.textContent = data.total.students;
      buildNumbers( data.total );
      buildStatus( data.status, data.total.students );
      base.buildClassName();
    })
    .catch( error => { console.log(error); });
}

selectClassroomElement.addEventListener( "change", function () {
  loadClassroomStats( selectClassroomElement.value );
});

base.BuildUserName();
base.BuildSelectClassroom();
