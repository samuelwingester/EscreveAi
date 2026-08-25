export class EscreveAiApi{
    constructor (){}

    static getBaseUrl(){
        return "http://127.0.0.1:8000/api";
    }

    static getTokenBearer( local = true ){
        let $token = null; 
        if ( local ) $token = localStorage.getItem( 'token-bearer' ); 
        else $token = sessionStorage.getItem( 'token-bearer' ); 
        return $token;
    }

    static setTokenBearer( token, local = true ){
        if ( local ) localStorage.setItem( 'token-bearer', token ); 
        else sessionStorage.setItem( 'token-bearer', token );
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
}