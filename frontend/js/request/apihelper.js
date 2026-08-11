export function getEscreveAiApiBaseUrl(){
    return "http://127.0.0.1:8000/api";
}

export function getTokenBearer( local = true ){
    let $token = ""
    if ( local ){ $token = localStorage.getItem( 'token-bearer' ); } 
    else{ $token = sessionStorage.getItem( 'token-bearer' ); }
    return $token;
}

export function setTokenBearer( token, local = true ){
    if ( local ){ localStorage.setItem( 'token-bearer', token ); } 
    else{ sessionStorage.setItem( 'token-bearer', token ); }
}

export function getDefaultAuthHeader(){
    $token = getTokenBearer();

    return  {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };
}

export function getDefaultHeader(){
    return  {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };
}

export async function fetchApiWithAuth( route, method = "GET", body = null, header = null ){
    const response = fetch( getEscreveAiApiBaseUrl() + route, {
        method : method,
        headers : !header ? getDefaultAuthHeader() : header,
        body : !body ? "" : body
    });
    return response;
}

export async function fetchApi( route, method = "GET", body = null, header = null ){
    const response = fetch( getEscreveAiApiBaseUrl() + route, {
        method : method,
        headers : !header ? getDefaultHeader() : header,
        body : !body ? body : ""
    });
    return response;
}