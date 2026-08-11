import { apiHelper } from "./apihelper.js";

// Isaac preciso de uma função para mostrar erros de validação ou outros no html

const register_form = document.getElementById( "register-form" );

// Esse e o fluxo base de uma requisição
// NOTA: e necessario do token que e retornado na requisição de login e register 
// para fazer requisições para o resto da aplicação
register_form.addEventListener( "submit", async function ( e )  {
    // Necessario formulario quebra sem essa função
    e.preventDefault()

    // Use os atributos do formulario para pegar os valores do input e 
    // melhor fiz assim so pra ser mais rapido, e precisa do atributo { name } nos inputs
    const email = document.getElementById( "input_email" ).value;
    const password = document.getElementById( "input_password" ).value;
    const password_confirmation = document.getElementById( "input_password_confirmation" ).value;

    const name = document.getElementById( "input_name" ).value;
    const date = document.getElementById( "input_birth_date" ).value;
    const gender = document.getElementById( "input_gender" ).value;

    const remember = document.getElementById( "checkbox_remember" ).value;

    // Isaacc faça a validação aqui

    let data = null;

    try{
        const response = await apiHelper.fetchApi( "/register", "POST", { 
            "email":email, 
            "password":password,
            "password_confirmation":password_confirmation,
            "name":name,
            "birth_date":date,
            "gender":gender 
        } );
        
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
