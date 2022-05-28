class Inscricao {
    patterns =  {
        email: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
        username: /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/,
        senha: /.*\S.*/
    };
    compilaInscricao = function () {
        const submitInscricaoButton = document.getElementById("submit-inscricao");
        const usernameInscricaoField = document.getElementById("username-inscricao");
        const emailInscricaoField = document.getElementById("email-inscricao");
        const senhaInscricaoField = document.getElementById("senha-inscricao");
        submitInscricaoButton.disabled = true;
        const fieldPatterns = [
            {
                field: usernameInscricaoField, 
                pattern: this.patterns.username,
                message: "Informe o nome de usuário"
            },
            {
                field: emailInscricaoField,
                pattern: this.patterns.email,
                message: "Informe o email"
            },
            {
                field: senhaInscricaoField,
                pattern: this.patterns.senha,
                message: "Informe a senha"
            }
        ]
        submitInscricaoButton.onclick = (e) => {
            let id;
            if(!(id = new Inscricao().validateFieldPatterns(fieldPatterns))) {
                $.post(
                    'http://localhost:8000/inscricao', 
                    {
                        "nome-inscricao": usernameInscricaoField.value, 
                        "email-inscricao": emailInscricaoField.value, 
                        "senha-inscricao": senhaInscricaoField.value
                    }).done(
                        function(data){
                            console.log("Login realizado com sucesso!");
                            Toastify({
                                text: "Inscrição realizada com sucesso!",
                                duration: 3000,
                                style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                            }).showToast();
                            setTimeout(function() {
                                sessionStorage.setItem('ingame', true);
                                window.location = "game.html";
                            }, 3000);
                        }
                    ).fail(
                        function(error) {
                            Toastify({
                                text: error.responseText,
                                duration: 3000,
                                style: {
                                background: "linear-gradient(to right, #b09b00, #ff0000)",
                                },
                            }).showToast();
                        }
                    );
            }
            
            submitInscricaoButton.disabled = true;
            const fieldError = fieldPatterns.filter(
                (pattern) => { 
                    if(pattern.field.getAttribute('id') == id) { 
                        return pattern;
                    }
                }).map(
                    (pattern) => {
                    return {
                        'field': pattern.field,
                        'message': pattern.message
                    };
                })[0];
                
            Toastify({
                text: fieldError.message,
                duration: 3000,
                style: {
                background: "linear-gradient(to right, #b09b00, #ff0000)",
                },
            }).showToast();
        }
        usernameInscricaoField.onkeyup = function(e){
            submitInscricaoButton.disabled = new Inscricao().validateFieldPatterns(fieldPatterns);
        }
        emailInscricaoField.onkeyup = function(e){
            submitInscricaoButton.disabled = new Inscricao().validateFieldPatterns(fieldPatterns);
        }
        senhaInscricaoField.onkeyup = function(e){
            submitInscricaoButton.disabled = new Inscricao().validateFieldPatterns(fieldPatterns);
        }
    }
    validateFieldPatterns = function (fieldPatterns) {
        let invalid = false;
        for(let item of fieldPatterns) {
            item.field.classList.remove("invalido");
            if(!item.pattern.test(item.field.value)) {
                item.field.classList.add("invalido");
                invalid = item.field.getAttribute('id');
                break;
            }
        }
        return invalid;
    }
}