import { apiHelper } from "./apihelper.js";

// Isaac preciso de uma função para mostrar erros de validação ou outros no html

const login_form = document.getElementById( "login-form" );

// Esse e o fluxo base de uma requisição
// NOTE: e necessario do token que e retornado na requisição de login e register 
// para fazer requisições para o resto da aplicação
login_form.addEventListener( "submit", async function ( e )  {
    // Necessario formulario quebra sem essa função
    e.preventDefault()

    const email = document.getElementById( "input_user_email" ).value;
    const password = document.getElementById( "input_user_password" ).value;
    const remember = document.getElementById( "checkbox_remember" ).value;

    // Isaacc faça a validação aqui -> email|password

    let data = null;

    try{
        const response = await apiHelper.fetchApi( "/login", "POST", { "email":email, "password":password } );
        
        data = await response.json();

        if ( !response.ok ) throw { message : "HTTP ERROR ", status : response.status};

        apiHelper.setTokenBearer( data["token"], remember ); //não sei se a checkbox funciona diretamente como booleano

        window.location.href = "./testing.html"; // redireciona para a pagina de teste mudar quando tiver a page de home
    } catch( error ){
        console.log( error )
        // Tratamento de erros de requisição aqui
        if ( error.status === 422 ){
            console.log(data)
            // Erros de validação - NOTA: Boa sorte com isso kkkkk
        }
    }
});


