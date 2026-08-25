import { EscreveAiApi } from "./EscreveAiApi.js";
import * as util from "./utils.js";

const login_form = document.getElementById( "login-form" );

login_form.addEventListener( "submit", async function ( e )  {
    debugger
    // Necessario formulario quebra sem essa função
    e.preventDefault();

    const formData = new FormData( login_form ); 

    const email = formData.get( "email" );
    const password = formData.get( "password" );
    const remember = formData.get( "remember" );

    util.clearError();

    // Validação ainda necessaria

    let data = null;

    try{
        const response = await EscreveAiApi.fetch( "/login", "POST", { "email":email, "password":password } );
   
        if ( !response.ok ) throw { message : "HTTP ERROR ", status : response.status};

        data = await response.json();

        EscreveAiApi.setTokenBearer( data["token"], true ); 

        window.location.href = "./dashboard.html"; 
    } catch( error ){
        if ( error.status !== 422 ){
            util.showError("Ocorreu um erro ao realizar o login.")
            //console.error(error);
            return;
        }

        let messages = "";

        if ( !data.errors ){ messages = `<p>${data.message}</p>`; }
        else {
            for ( const field in data.errors ){
                data.errors[ field ].forEach( message => {
                    messages += `<p>${message}</p>`;
                });
            }
        }

        util.showError( messages );
    }
});
