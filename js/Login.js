class Login {
    patterns =  {
        email: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
        nomedeusuario: /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/,
        senha: /.*\S.*/
    };
    compilaLogin = function () {
        const nomedeusuarioField = document.getElementById("nomedeusuario");
        const senhaField = document.getElementById("senha");
        const submitButton = document.getElementById("submit");
        submitButton.disabled = true;
        const fieldPatterns = [
            {
                field: nomedeusuarioField, 
                pattern: this.patterns.nomedeusuario,
                message: "Informe o nome de usuário ou o email"
            },
            {
                field: senhaField,
                pattern: this.patterns.senha,
                message: "Informe a senha"
            }
        ]
        submitButton.onclick = (e) => {
            let id;
            if(!(id = new Inscricao().validateFieldPatterns(fieldPatterns))) {
                $.post(
                    '/login', 
                    {
                        "nomedeusuario": nomedeusuarioField.value, 
                        "senha": senhaField.value
                    }).done(
                        function(data){
                            window.sessionStorage.setItem('userId', data.id);
                            const expiraEm = new Date();
                            expiraEm.setTime(data.expiraEm * 1000);
                            document.cookie = `username=${data.nomedeusuario}; expires=${expiraEm.toUTCString()}`;
                            Toastify({
                                text: "Login realizado com sucesso!",
                                duration: 3000,
                                style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                            }).showToast();
                            setTimeout(function() {
                                sessionStorage.setItem('ingame', true);
                                window.location = "game.php";
                            }, 3000);
                        }
                    ).fail(
                        function(error) {
                            let destination = "#"
                            if(error.responseText.includes('meiodiagames.herokuapp.com')) {
                                destination = 'https://meiodiagames.herokuapp.com';
                            }
                            Toastify({
                                text: error.responseText,
                                duration: 3000,
                                style: {
                                background: "linear-gradient(to right, #b09b00, #ff0000)",
                                },
                                destination
                            }).showToast();
                        }
                    );
            } else {
                submitButton.disabled = true;
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
        }
        nomedeusuarioField.onkeyup = function(e){
            submitButton.disabled = new Login().validateFieldPatterns(fieldPatterns);
        }
        senhaField.onkeyup = function(e){
            submitButton.disabled = new Inscricao().validateFieldPatterns(fieldPatterns);
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