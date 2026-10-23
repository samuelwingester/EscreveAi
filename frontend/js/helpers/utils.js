export function showError(message) {
  const errorElement = document.querySelector(".error-banner");

  errorElement.innerHTML = message;
  errorElement.hidden = false;
}

export function clearError() {
  const errorElement = document.querySelector(".error-banner");

  errorElement.innerHTML = "";
  errorElement.hidden = true;
}

export function retrieve( key ) {
  let value = localStorage.getItem( key );

  if ( !value ) value = sessionStorage.getItem( key );

  return value
}

export function store( key, value, remember = null ) {
  if ( remember == null ) remember = retrieve( 'remember' )
  if ( !remember ) sessionStorage.setItem( key, value );
  else localStorage.setItem( key, value );
}

export function retrieveJSON( key ){
  return JSON.parse( retrieve( key ) );
}

export function storeJSON( key, value, remember = null ){
  store( key, JSON.stringify(value), remember );
}

export function remove( key ) {
  localStorage.removeItem( key );
  sessionStorage.removeItem( key );
}

export function getSelectedClassroom() {
  const selected = document.getElementById("select-turma-overlay").value;
  const data = retrieveJSON("list-classrooms");

  if ( !data ) { return null; }

  const classroom = Object.entries( data ).find( ([classroom_id]) => classroom_id == selected );

  if ( !classroom ) { return null; }

  const [classroom_id, name] = classroom;
  return {classroom_id, name};
}

export function formatDateLong(date) {
    if (!date) return "";

    return new Date(date).toLocaleDateString("pt-BR", {
        day: "numeric",
        month: "long",
        year: "numeric",
        timeZone: "America/Sao_Paulo",
    });
}

export function formatDateNumeric(date) {
    if (!date) return "";

    return new Date(date).toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        timeZone: "America/Sao_Paulo",
    });
}

// Mostra/limpa o erro no banner do próprio formulário (a página tem vários modais,
// então o util.showError, que usa o primeiro banner da página, não serve aqui).
 //codigo kaique, melhor aqui
export function showFormError( form, html ) {
  const banner = form.querySelector( '.error-banner' );

  banner.innerHTML = html;
  banner.hidden = false;
}

export function clearFormError( form ) {
  const banner = form.querySelector( '.error-banner' );

  banner.innerHTML = '';
  banner.hidden = true;
}
