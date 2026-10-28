import { EscreveAiApi } from "../helpers/EscreveAiApi.js";
import * as util from "../helpers/utils.js";
import * as base from "./base.js";

const CardsContainer = document.getElementById("activities-card-container");
const SelectClassroom = document.getElementById( "select-turma-overlay" );


const NewActivityForm = document.getElementById("new-activity-form");
const UpdateActivityForm = document.getElementById("edit-activity-form");

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
      console.log(data)
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
      document.getElementById('add-activity-modal').close();

      //Ineficiente mas suficiente por agora
      const event = new Event( 'change' );
      SelectClassroom.dispatchEvent( event );
    })
    .catch( error => {
      let messages = "";

      if ( error.status === 422 ) { // Erros de validação do lado do servidor
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

document.addEventListener( 'activity-delete', function (e) {
  const { id } = e.detail;

  EscreveAiApi.fetchWithAuth( "/classroom/" + SelectClassroom.value + "/activity/" + id, "DELETE" )
    .then( response => {
      if ( !response.ok ) throw response;
      loadActivities( SelectClassroom.value );
      //base.BuildSelectClassroom();
    })
    .catch( error => { console.log(error); } );
});

document.addEventListener( 'activity-edit', function (e) {
  const { id } = e.detail;

  const titleInput = document.getElementById( "input-edit-activity-name" );
  const descriptionInput = document.getElementById( "input-edit-activity-description" );

  document.getElementById("input-edit-activity-id").value = id;

  EscreveAiApi.fetchWithAuth( "/classroom/" + SelectClassroom.value + "/activity/" + id, "GET" )
    .then( response => {
      if ( !response.ok ) throw response;
      return response.json();
    })
    .then( data => {
      data = data.activity;
      titleInput.value = data.title;
      descriptionInput.value = data.description;
      document.getElementById('edit-activity-modal').showModal()
    })
    .catch( error => { console.log(error); } );
});

UpdateActivityForm.addEventListener( 'submit', function ( e ) {
  e.preventDefault();

  const id = document.getElementById("input-edit-activity-id").value;

  const formData = new FormData( UpdateActivityForm );
  const data = new FormData();

  data.append('title', formData.get('title'));
  data.append('description', formData.get('description'));

  const files = formData.getAll('attachments');

  files.forEach((file, index) => {
    if (file.size > 0) {
      data.append(`attachments[${index}][file]`, file);
    }
  });

  util.clearFormError( UpdateActivityForm );

  EscreveAiApi.fetchWithAuth( "/classroom/" + SelectClassroom.value + "/activity/" + id, "PUT", data )
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
      document.getElementById('edit-activity-modal').close();

      //Ineficiente mas suficiente por agora
      const event = new Event( 'change' );
      SelectClassroom.dispatchEvent( event );
    })
    .catch( error => {
      let messages = "";

      if ( error.status === 422 ) { // Erros de validação do lado do servidor
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

      util.showFormError( UpdateActivityForm, messages );
    });
});

document.addEventListener( 'activity-view', function (e){
  const { id } = e.detail;

  const title = document.getElementById( "view-activity-title" );
  const description = document.getElementById( "view-activity-description" );
  const cont = document.getElementById( "view-anexos-container" );

  document.getElementById("input-edit-activity-id").value = id;

  EscreveAiApi.fetchWithAuth( "/classroom/" + SelectClassroom.value + "/activity/" + id, "GET" )
    .then( response => {
      if ( !response.ok ) throw response;
      return response.json();
    })
    .then( data => {
      data = data.activity;
      title.innerHTML = data.title;
      description.innerHTML = data.description;

      cont.innerHTML = '';
      data.attachments.forEach( att => {
        const card = document.createElement( 'attachment-card' );

        card.filename = att.file_name;
        card.anexo_id = att.id;
        card.type = att.type;
        card.url = att.url;

        cont.appendChild( card );
      });

      document.getElementById('view-activity-modal').showModal();
    })
    .catch( error => { console.log(error); } );
});

document.addEventListener( 'anexo-delete', function (e) {
  const { id, filename, type, url } = e.detail;

  EscreveAiApi.fetchWithAuth('/file/' + id, 'DELETE')
    .then(response => {
      if (!response.ok) { throw new Error(`HTTP ${response.status}`); }
      document.getElementById('view-activity-modal').close();
      loadActivities( SelectClassroom.value );
    })
    .catch(error => {
      console.error('Falha ao deletar anexo:', error);
    });
});

document.addEventListener( 'anexo-download', function (e) {
  const { id, filename, type, url } = e.detail;

  EscreveAiApi.fetchWithAuth('/file/' + id, 'GET')
    .then(response => {
      if (!response.ok) { throw new Error(`HTTP ${response.status}`); }
      return response.blob();
    })
    .then(blob => {
      const objectUrl = URL.createObjectURL(blob);
      const link = document.createElement('a');

      link.href = objectUrl;
      link.download = filename;

      document.body.appendChild(link);
      link.click();
      link.remove();

      setTimeout(() => { URL.revokeObjectURL(objectUrl); }, 1000);
    })
    .catch(error => {
      console.error('Falha ao baixar anexo:', error);
    });
});

document.addEventListener( 'anexo-view', function (e) {
  const { id, filename, type, url } = e.detail;

  const tab = window.open('about:blank', '_blank');

    EscreveAiApi.fetchWithAuth('/file/' + id + '/download', 'GET')
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP ${response.status}`); }
        return response.blob();
      })
      .then(blob => {
        const objectUrl = URL.createObjectURL(blob);

        if (tab) { tab.location.href = objectUrl; }
        else { window.location.href = objectUrl; }

        setTimeout(() => URL.revokeObjectURL(objectUrl), 60_000);
      })
      .catch(error => {
        tab?.close();
        console.error('Falha ao visualizar anexo:', error);
      });
});
