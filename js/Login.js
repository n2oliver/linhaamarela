class Login {
    patterns =  {
        email: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
        nomedeusuario: /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/,
        senha: /.*\S.*/
    }

    appUrl = '/jogos/linhaamarela';
    campoEmail = $('#email');
    campoSenha = $('#campo-senha');
    codigoEmail = $('#codigo-email');
    codigoEnviado = $('#codigo-enviado');
    naoRecebiEmail = $('#nao-recebi');
    cancelarEsqueciSenhaEmail = $('#cancelar');
    verificar = $('#verificar');
    cadastrarSenha = $('#cadastrar-senha');

    login = () => {
        this.removeNotifications();
        const email = this.campoEmail.val();
        const senha = this.campoSenha.val();
        $.ajax({
            url: `${this.appUrl}/login.php`,
            data: { email, senha },
            type: 'POST',
            success: (response) => {
                Toastify({
                    text: "Você já pode começar!",
                    duration: 10000,
                    close: true
                }).showToast();
                setTimeout(()=>{
                    window.location.href=`${this.appUrl}/game.php`;
                }, 3000);

            },
            error: (xhr) => {
                Toastify({
                    text: JSON.parse(xhr.responseText).error,
                    duration: 10000,
                    className: 'error',
                    close: true
                }).showToast();
            }
        })
    }

    naoTenhoConta = () => {
        this.removeNotifications();
        const email = this.campoEmail.val();
        this.codigoEnviado.val('');

        if(!email.trim()) {
            Toastify({
                text: "Preencha primeiro o campo email!",
                duration: 10000,
                className: 'error',
                close: true
            }).showToast();
            return;
        }

        this.campoSenha.addClass('d-none');
        this.cadastrarSenha.addClass('d-none');
        this.codigoEmail.removeClass('d-none');
        this.naoRecebiEmail.removeClass('d-none');
        this.cancelarEsqueciSenhaEmail.removeClass('d-none');

        this.naoRecebiEmail.click(()=>{
            this.removeNotifications();
            
            this.codigoEnviado.val('');
            
            $.ajax({
                url: `${this.appUrl}/retry-email-verify.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })

        });
        
        this.verificar.click(()=>{
            this.removeNotifications();

            $.ajax({
                url: `${this.appUrl}/check-recovery.php`,
                data: { codigo: this.codigoEnviado.val() },
                xhrFields: {
                    withCredentials: true
                },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    this.codigoEnviado.val('');
                    this.liberarCampoCadastrarSenha();
                    this.cadastrarSenha.click(()=>{
                        $.ajax({
                            url: `${this.appUrl}/password-create.php`,
                            data: { email, senha },
                            xhrFields: {
                                withCredentials: true
                            },
                            type: 'POST',
                            success: (response) => {
                            },
                            error: (xhr) => {

                            }
                        });
                    });
                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                    window.location.reload();
                }
            })
        });
        
        $(document).ready(()=>{
            Toastify({
                text: 'Enviando código de verificação...',
                duration: 10000,
                close: true
            }).showToast();
            $.ajax({
                url: `${this.appUrl}/password-create-mail.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })
        })
    }

    passwordRecovery = () => {    
        const email = this.campoEmail.val();

        this.removeNotifications();

        this.codigoEnviado.val('');

        if(!this.campoEmail.val().trim()) {
            Toastify({
                text: "Preencha primeiro o campo email!",
                duration: 10000,
                className: 'error',
                close: true
            }).showToast();
            return;
        }
        this.campoSenha.addClass('d-none');
        this.codigoEmail.removeClass('d-none');
        this.naoRecebiEmail.removeClass('d-none');
        this.cancelarEsqueciSenhaEmail.removeClass('d-none');
        this.cadastrarSenha.addClass('d-none');
        
        this.cancelarEsqueciSenhaEmail.click(()=> {
            this.removeNotifications();

            this.codigoEnviado.val('');

            this.campoSenha.removeClass('d-none');
            this.codigoEmail.addClass('d-none');
            this.naoRecebiEmail.addClass('d-none');
            this.cadastrarSenha.addClass('d-none');
            this.cancelarEsqueciSenhaEmail.addClass('d-none');
        });

        this.naoRecebiEmail.click(()=>{
            this.removeNotifications();

            this.codigoEnviado.val('');
            Toastify({
                text: 'Enviando código de verificação...',
                duration: 10000,
                close: true
            }).showToast();
            $.ajax({
                url: `${this.appUrl}/retry-password-recovery.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })

        });
        
        this.verificar.click(()=>{
            this.removeNotifications();
            
            Toastify({
                text: 'Validando código de verificação...',
                duration: 10000,
                close: true
            }).showToast();

            $.ajax({
                url: `${this.appUrl}/check-recovery.php`,
                data: { codigo: this.codigoEnviado.val() },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    this.codigoEnviado.val('');
                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })
        });

        $(document).ready(()=>{
            Toastify({
                text: 'Enviando código de verificação...',
                duration: 10000,
                close: true
            }).showToast();
            $.ajax({
                url: `${this.appUrl}/password-recovery.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })
        })
    }
    cadastrar = () => {
        this.validarEmail();
    }
    
    validarEmail = () => {
        this.removeNotifications();
        
        this.campoSenha.addClass('d-none');
        this.codigoEmail.addClass('d-none');
        this.cadastrarSenha.removeClass('d-none');
    }

    sairCadastro = () => {
        this.removeNotifications();
        
        this.codigoEnviado.val('');

        this.campoSenha.removeClass('d-none');
        this.codigoEmail.addClass('d-none');
        this.cancelarEsqueciSenhaEmail.addClass('d-none');
        this.cadastrarSenha.addClass('d-none');
    }
    removeNotifications = () => {
        for(let toast of document.querySelectorAll('.toastify')) {
            toast.remove();
        }
    }
    liberarCampoCadastrarSenha = () => {
        this.cadastrarSenha.removeClass('d-none');
        this.campoSenha.addClass('d-none');
        this.codigoEmail.addClass('d-none');
    }
}