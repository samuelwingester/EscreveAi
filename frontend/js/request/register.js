import { apiHelper } from "./apihelper.js";

// Isaac preciso de uma função para mostrar erros de validação ou outros no html
// Função para mostrar erros no HTML
function showError(message) {
    const errorElement = document.getElementById("error-message");

    errorElement.innerHTML = message;
    errorElement.style.color = "red";
}

// Função para limpar erros
function clearError() {
    const errorElement = document.getElementById("error-message");

    errorElement.innerHTML = "";
}

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

    const remember = document.getElementById( "checkbox_remember" ).checked; // Checkbox é com "checked", não "value", daí pode ser valor booleano

    // Valuidação
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

        window.location.href = "./home.html"; // redireciona para a pagina de teste mudar quando tiver a page de home
    } catch( error ){
        console.log( error )
        // Tratamento de erros de requisição aqui
        if ( error.status === 422 ){
            console.log(data)
            console.log(data);
            let messages = "";
            if (data.errors) {
                for (const field in data.errors) {
                    data.errors[field].forEach(message => {
                        messages += `<p>${message}</p>`;
                    });
                }
            } else {
                messages = `<p>${data.message}</p>`;
            }
            showError(messages);
        } else {
            showError("Ocorreu um erro ao realizar o cadastro.")
        }
    }
});
