import * as util from "./utils.js";

export class EscreveAiApi{
  constructor (){}

  static getBaseUrl(){
      return "http://127.0.0.1:8000/api";
  }

  static getTokenBearer(){
    return util.retrieve( 'token-bearer' )
  }

  static setTokenBearer( token, remember = true ){
    util.store( 'token-bearer', token, remember );
  }

  static getDefaultAuthHeader(){
    const token = EscreveAiApi.getTokenBearer();

    if ( !token ) throw "Unable to retrieve token";

    return  {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    };
  }

  static getDefaultHeader(){
    return  {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    };
  }

  static async fetchWithAuth( route, method = "GET", body = null, header = null ){
    const full_route = EscreveAiApi.getBaseUrl() + route;
    const options = {
      method : method,
      headers : !header ? EscreveAiApi.getDefaultAuthHeader() : header
    };

    if ( body ){ options.body = JSON.stringify( body ); }

    return fetch( full_route, options );
  }

  static async fetch( route, method = "GET", body = null, header = null ){
    const full_route = EscreveAiApi.getBaseUrl() + route;
    const options = {
      method : method,
      headers : !header ? EscreveAiApi.getDefaultHeader() : header
    };

    if ( body ){ options.body = JSON.stringify( body ); }

    return fetch( full_route, options );
  }

  static async logout() {
    EscreveAiApi.fetchWithAuth( '/logout', 'POST' )
      .then( response => {
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = "./home.html";
      })
  }
}
