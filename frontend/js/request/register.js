import { EscreveAiApi } from "./EscreveAiApi.js";
import "./utils.js"

const register_form = document.getElementById( "register-form" );

register_form.addEventListener( "submit", async function ( e )  {
    // Necessario formulario quebra sem essa função
    e.preventDefault()

    const formData = new FormData( register_form );

    const email = formData.get( "email" );
    const password = formData.get( "password" ); 
    const password_confirmation = formData.get( "password-confirmation" ); 

    const name = formData.get( "name" );
    const date = formData.get( "date" );

    const remember = document.getElementById( "checkbox_remember" ).checked; 

    clearError();
    
    if (!email) {
        showError("Informe seu e-mail.");
        return;
    }

    if (!password) {
        showError("Informe sua senha.");
        return;
    }

    if (!password_confirmation) {
        showError("Confirme sua senha.");
        return;
    }

    if (password !== password_confirmation) {
        showError("As senhas não são iguais.");
        return;
    }

    if (!name) {
        showError("Informe seu nome.");
        return;
    }

    if (!date) {
        showError("Informe sua data de nascimento.");
        return;
    }

    if (!gender) {
        showError("Selecione seu gênero.");
        return;
    }

    let data = null;

    try{
        const response = await EscreveAiApi.fetchApi( "/register", "POST", { 
            "email":email, 
            "password":password,
            "password_confirmation":password_confirmation,
            "name":name,
            "gender":gender 
        } );
        
        data = await response.json();

        if ( !response.ok ) throw { message : "HTTP ERROR ", status : response.status};

        EscreveAiApi.setTokenBearer( data["token"], remember );

        window.location.href = "./dashboard.html"; 
    } catch( error ){
        if ( error.status !== 422 ){
            showError("Ocorreu um erro ao realizar o cadastro.")
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
        
        showError( messages );
    }
});
