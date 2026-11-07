
// Utilidades de manipulação de DOM que estavam repetidas em request/student.js e components/common/Field.js.
export function fillSelect( select, items ) {
  select.innerHTML = '';

  Object.entries( items ).forEach( ([ id, name ]) => {
    const option = document.createElement( 'option' );

    option.textContent = name;
    option.value = id;

    select.appendChild( option );
  });
}
