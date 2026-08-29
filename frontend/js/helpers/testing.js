import { EscreveAiApi } from "./EscreveAiApi.js";

// Não sei que merda e essa. codigo de ia para teste
function syntaxHighlight(json) {
  json = JSON.stringify(json, null, 2)
    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  return json.replace(
    /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false)\b|null|-?\d+(\.\d+)?([eE][+-]?\d+)?)/g,
    function (match) {
      let cls = 'number';
      if (/^"/.test(match)) {
        cls = /:$/.test(match) ? 'key' : 'string';
      } else if (/true|false/.test(match)) {
        cls = 'boolean';
      } else if (/null/.test(match)) {
        cls = 'null';
      }
      return '<span class="' + cls + '">' + match + '</span>';
    }
  );
}

function renderJson(data) {
  document.getElementById('output').innerHTML = syntaxHighlight(data);
}

try{
const result = await EscreveAiApi.fetchWithAuth( '/classroom/' + 1 + '/student' )
  .then( response => {
    if ( !response.ok ) throw new Error();
    return response.json();
  })
  .then( data => {
    if ( data == null ) throw new Error();
    return data;
  })
  .catch( error => { console.log( error ) } );

renderJson(result);
} catch( error ) { console.log( error ) }
