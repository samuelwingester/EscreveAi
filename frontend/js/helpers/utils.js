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
