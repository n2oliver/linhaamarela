class Login {
    patterns =  {
        email: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
        nomedeusuario: /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/,
        senha: /.*\S.*/
    }

    appUrl = '/jogos/linhaamarela';
    camadaNome = $('#camada-nome');
    camadaEmail = $('#camada-email');

    campoNome = $('#nome');
    campoEmail = $('#email');
    campoSenha = $('#senha');
    camadaSenha = $('#camada-senha');
    codigoEmail = $('#codigo-email');
    codigoEnviado = $('#codigo-enviado');
    naoRecebiEmail = $('#nao-recebi');
    cancelarEsqueciSenhaEmail = $('#cancelar');
    verificar = $('#verificar');
    btnCadastrar = $('#cadastrar');
    cadastrarSenha = $('#cadastrar-senha');
    cadastroSenha = $('#cadastro-senha');

    login = () => {
        this.removeNotifications();
        this.showSpinner();
        const email = this.campoEmail.val();
        const senha = this.camadaSenha.val();
        $.ajax({
            url: `${this.appUrl}/login.php`,
            data: { email, senha },
            type: 'POST',
            success: (response) => {
                this.showSpinner('hide');
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
                this.showSpinner('hide');
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
        this.showSpinner();
        const email = this.campoEmail.val();
        this.codigoEnviado.val('');

        if(!email.trim()) {
            this.showSpinner('hide');
            Toastify({
                text: "Preencha primeiro o campo email!",
                duration: 10000,
                className: 'error',
                close: true
            }).showToast();
            return;
        }

        this.camadaSenha.addClass('d-none');
        this.cadastrarSenha.addClass('d-none');
        this.codigoEmail.removeClass('d-none');
        this.naoRecebiEmail.removeClass('d-none');
        this.cancelarEsqueciSenhaEmail.removeClass('d-none');

        this.naoRecebiEmail.unbind('click').click(()=>{
            this.codigoEnviado.val('');

            this.removeNotifications();
            this.showSpinner();
            Toastify({
                text: 'Enviando código de verificação...',
                duration: 10000,
                close: true
            }).showToast();
                        
            $.ajax({
                url: `${this.appUrl}/retry-email-verify.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    setTimeout(()=>{
                        window.open(`https://${email}`)
                    }, 4000);
                },
                error: (xhr) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })

        });
        
        this.verificar.unbind('click').click(()=>{
            this.removeNotifications();
            this.showSpinner();
            Toastify({
                text: 'Verificando código...',
                duration: 10000,
                close: true
            }).showToast();

            $.ajax({
                url: `${this.appUrl}/check-recovery.php`,
                data: { codigo: this.codigoEnviado.val() },
                xhrFields: {
                    withCredentials: true
                },
                type: 'POST',
                success: (response) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    this.codigoEnviado.val('');
                    this.liberarCampoCadastrarSenha();

                    this.camadaNome.removeClass('d-none');
                    this.camadaEmail.addClass('d-none');

                    this.btnCadastrar.unbind('click').click(()=>{
                        this.removeNotifications();
                        this.showSpinner();
                        Toastify({
                            text: 'Aguarde a conclusão do cadatro...',
                            duration: 10000,
                            className: 'success',
                            close: true
                        }).showToast();
                        const nome = this.campoNome.val();
                        const senha = this.cadastroSenha.val();
                        if(!nome.trim() || !senha.trim()) {
                            this.removeNotifications();
                            this.showSpinner('hide');
                            Toastify({
                                text: 'Preencha todos os campos!',
                                duration: 10000,
                                className: 'warning',
                                close: true
                            }).showToast();
                            return;
                        }
                        $.ajax({
                            url: `${this.appUrl}/password-create.php`,
                            data: { nome, senha },
                            xhrFields: {
                                withCredentials: true
                            },
                            type: 'POST',
                            success: (response) => {
                                this.removeNotifications();
                                this.showSpinner('hide');
                                Toastify({
                                    text: JSON.parse(response).data,
                                    duration: 10000,
                                    className: 'success',
                                    close: true
                                }).showToast();
                            },
                            error: (xhr) => {
                                this.removeNotifications();
                                this.showSpinner('hide');
                                Toastify({
                                    text: JSON.parse(xhr.responseText).error,
                                    duration: 10000,
                                    className: 'error',
                                    close: true
                                }).showToast();
                            }
                        });
                    });
                },
                error: (xhr) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })
        });
        
        this.cancelarEsqueciSenhaEmail.unbind('click').click(()=> {
            this.removeNotifications();
            this.showSpinner('hide');

            this.codigoEnviado.val('');

            this.camadaSenha.removeClass('d-none');
            this.codigoEmail.addClass('d-none');
            this.naoRecebiEmail.addClass('d-none');
            this.cadastrarSenha.addClass('d-none');
            this.cancelarEsqueciSenhaEmail.addClass('d-none');

            this.campoEmail.prop('disabled', false);
        });

        $(document).ready(()=>{
            this.campoEmail.prop('disabled', true);
            this.removeNotifications();
            this.showSpinner();
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
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    setTimeout(()=>{
                        window.open(`https://${email}`)
                    }, 4000);
                },
                error: (xhr) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
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
        this.removeNotifications();
        this.showSpinner();  
        const email = this.campoEmail.val();


        this.codigoEnviado.val('');

        if(!this.campoEmail.val().trim()) {
            this.removeNotifications();
            this.showSpinner('hide');
            Toastify({
                text: "Preencha primeiro o campo email!",
                duration: 10000,
                className: 'error',
                close: true
            }).showToast();
            return;
        }
        this.camadaSenha.addClass('d-none');
        this.codigoEmail.removeClass('d-none');
        this.naoRecebiEmail.removeClass('d-none');
        this.cancelarEsqueciSenhaEmail.removeClass('d-none');
        this.cadastrarSenha.addClass('d-none');
        
        this.cancelarEsqueciSenhaEmail.unbind('click').click(()=> {
            this.removeNotifications();
            this.showSpinner('hide');

            this.codigoEnviado.val('');

            this.camadaSenha.removeClass('d-none');
            this.codigoEmail.addClass('d-none');
            this.naoRecebiEmail.addClass('d-none');
            this.cadastrarSenha.addClass('d-none');
            this.cancelarEsqueciSenhaEmail.addClass('d-none');

            this.campoEmail.prop('disemailabled', false);
        });

        this.naoRecebiEmail.unbind('click').click(()=>{
            this.codigoEnviado.val('');

            this.removeNotifications();
            this.showSpinner();
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
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    setTimeout(()=>{
                        window.open(`https://${email}`)
                    }, 4000);
                },
                error: (xhr) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 10000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })

        });
        
        this.verificar.unbind('click').click(()=>{
            this.removeNotifications();
            this.showSpinner();
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
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    this.codigoEnviado.val('');
                },
                error: (xhr) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
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
            this.campoEmail.prop('disabled', true);
            this.removeNotifications();
            this.showSpinner();
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
                    this.removeNotifications();
                    this.showSpinner('hide');
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 10000,
                        className: 'success',
                        close: true
                    }).showToast();
                    setTimeout(()=>{
                        window.open(`https://${email}`)
                    }, 4000);
                },
                error: (xhr) => {
                    this.removeNotifications();
                    this.showSpinner('hide');
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

    sairCadastro = () => {
        this.removeNotifications();
        this.showSpinner('hide');
        
        this.codigoEnviado.val('');

        this.camadaSenha.removeClass('d-none');
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
        this.camadaSenha.addClass('d-none');
        this.codigoEmail.addClass('d-none');
    }
    showSpinner = (state) => {
        if(!state) {
            $('.spinner').removeClass('d-none');
            return;
        }
        $('.spinner').addClass('d-none');
    }
}