import { fetchListClassroom } from "../helpers/requests.js";
import * as util from "../helpers/utils.js";

BuildUserName();
BuildSelectClassroom();

async function BuildUserName() {
  const usernameClasss = document.querySelectorAll( ".nome-professor" );

  const username = util.retrieve( 'username' );

  usernameClasss.forEach( element => element.textContent = username )
}

async function BuildSelectClassroom(){
  const selectClassroomElement = document.getElementById( "select-turma-overlay" );

  let classrooms = util.retrieveJSON( "list-classrooms" );

  if ( classrooms === null ){
    classrooms = await fetchListClassroom()
    .then( data => {
      if ( data === null ) throw Error("nenhuma turma encontrada");
      util.storeJSON( "list-classrooms", data );
      return data;
    })
    .catch( error => { // tratar depois
      console.log(error);
      return null;
    });
  }

  classrooms.forEach( classroom => {
    const newOption = document.createElement('option');
    newOption.textContent = classroom.name;
    newOption.value = classroom.id;
    selectClassroomElement.appendChild(newOption);
  })
}




