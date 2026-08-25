import { EscreveAiApi } from "./EscreveAiApi.js";

export async function fetchListClassroom(){
  return await EscreveAiApi.fetchWithAuth( '/classroom' )
    .then( response => {
      if ( !response.ok ) throw Error();//tratar depois agora não e tão importante
      return response.json();
    })
    .catch( data => null );
}
