import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";

const CardsContainer = document.getElementById("activities-card-container");
const SelectClassroom = document.getElementById( "select-turma-overlay" );

const NewActivityForm = document.getElementById("new-activity-form");

async function loadActivities( id ){
  EscreveAiApi.fetchWithAuth( '/classroom/' + id + '/activity?order_by=created_at' )
    .then( response => {
      if ( !response.ok ) throw new Error();
      return response.json();
    })
    .then( data => {
      if ( data == null ) throw new Error();
      base.buildClassName();

      CardsContainer.innerHTML = '';

      data.data.forEach( activity => {
        const card = document.createElement( 'activity-card' );

        card.title = activity.title;
        card.description = activity.description;
        card.activity_id = activity.id;
        card.fileCount = activity.attachments.length ?? 0;
        card.date = util.formatDateLong(activity.created_at);
        card.imgSrc = activity.preview_url || '../imgs/activities/IMG.png';

        CardsContainer.appendChild( card );
      });
    })
    .catch( error=>{ console.log(error) });
}

SelectClassroom.addEventListener( "change", function () {
  loadActivities( SelectClassroom.value );
});

NewActivityForm.addEventListener( 'submit', function ( e ) {
  e.preventDefault();

  const formData = new FormData( NewActivityForm );
  const data = new FormData();

  data.append('title', formData.get('title'));
  data.append('description', formData.get('description'));

  const files = formData.getAll('attachments');

  files.forEach((file, index) => {
    if (file.size > 0) {
      data.append(`attachments[${index}][file]`, file);
    }
  });

  util.clearFormError( NewActivityForm );
  console.log(data)

  EscreveAiApi.fetchWithAuth( "/classroom/" + SelectClassroom.value + "/activity", "POST", data )
    .then( response => {
      if ( !response.ok ) {
        return response.json().then( body => {
          const error = new Error();
          error.status = response.status;
          error.data = body;
          throw error;
        });
      }
      return response.json();
    })
    .then( data => {
      document.getElementById('activity-modal').close();

      //Ineficiente mas suficiente por agora
      const event = new Event( 'change' );
      SelectClassroom.dispatchEvent( event );
    })
    .catch( error => {
      let messages = "";

      if ( error.status === 422 ) { // Erros de vaildação do lado do servidor
        const data = error.data;
        for ( const field in data.errors ){
          data.errors[ field ].forEach( message => {
            messages += `<p>${message}</p>`;
          });
        }
      } else {
        messages = "Erro de rede";
        console.log(error);
      }

      util.showFormError( NewActivityForm, messages );
    });

});
