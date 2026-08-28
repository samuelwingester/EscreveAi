import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";

export async function BuildUserName() {
  const usernameClasss = document.querySelectorAll( ".nome-professor" );

  const username = util.retrieve( 'username' );

  usernameClasss.forEach( element => element.textContent = username )
}

export async function BuildSelectClassroom(){
  function makeList( data ){
    let clean = {};
    data.forEach( item => { clean[item.id] = item.name; })
    return clean;
  }

  const selectClassroomElement = document.getElementById( "select-turma-overlay" );
  let classrooms = util.retrieveJSON( "list-classrooms" );

  if ( classrooms === null ){
    await EscreveAiApi.fetchWithAuth( '/classroom' )
      .then( response => {
        if ( !response.ok ) throw new Error();
        return response.json()
      })
      .then( data => {
        if ( data === null ) throw Error("nenhuma turma encontrada");
        util.storeJSON( "list-classrooms", makeList( data ) );
      })
      .catch( error => {  console.log(error); });
  }

  classrooms = util.retrieveJSON( "list-classrooms" );

  Object.entries( classrooms ).forEach( ([ id, name ]) => {
    const newOption = document.createElement( 'option' );

    newOption.textContent = name;
    newOption.value = id;

    selectClassroomElement.appendChild(newOption);
  })

  const selected = util.getSelectedClassroom();

  if ( selected ) { selectClassroomElement.value = selected.id; }
  else if ( selectClassroomElement.options.length > 1 ){
    selectClassroomElement.value = selectClassroomElement.options[1].value;
  }

  const event = new Event( 'change' );
  selectClassroomElement.dispatchEvent( event );
}

export async function buildClassName(){
  const classroomElements = document.querySelectorAll( ".turma-titulo" );

  const data = util.getSelectedClassroom();
  if ( !data ) { return; }
  classroomElements.forEach( element => element.textContent = data.name );
}
