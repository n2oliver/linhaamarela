class Login {
    patterns =  {
        email: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
        nomedeusuario: /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/,
        senha: /.*\S.*/
    }
    login = () => {
        const email = $('#email').val();
        const senha = $('#senha').val();
        $.ajax({
            url: `${appUrl}/login.php`,
            data: { email, senha },
            type: 'POST',
            success: (response) => {
                Toastify({
                    text: "Você já pode começar!",
                    duration: 5000,
                    close: true
                }).showToast();
                setTimeout(()=>{
                    window.location.href=`${appUrl}/game.php`;
                }, 3000);

            },
            error: (xhr) => {
                Toastify({
                    text: JSON.parse(xhr.responseText).error,
                    duration: 5000,
                    className: 'error',
                    close: true
                }).showToast();
            }
        })
    }
    passwordRecovery = () => {
        const appUrl = '/jogos/linhaamarela'
        const email = $('#email').val();
        const campoSenha = $('#campo-senha');
        const codigoEmail = $('#codigo-email');
        const codigoEnviado = $('#codigo-enviado');
        const naoRecebiEmail = $('#nao-recebi');
        const cancelarEsqueciSenhaEmail = $('#cancelar');
        const verificar = $('#verificar');

        if(!email.trim()) {
            Toastify({
                text: "Preencha primeiro o campo email!",
                duration: 5000,
                className: 'error',
                close: true
            }).showToast();
            return;
        }
        campoSenha.addClass('d-none');
        codigoEmail.removeClass('d-none');
        naoRecebiEmail.removeClass('d-none');
        cancelarEsqueciSenhaEmail.removeClass('d-none');
        
        cancelarEsqueciSenhaEmail.click(()=> {
            campoSenha.removeClass('d-none');
            codigoEmail.addClass('d-none');
            naoRecebiEmail.addClass('d-none');
            cancelarEsqueciSenhaEmail.addClass('d-none');
        });

        naoRecebiEmail.click(()=>{
            $.ajax({
                url: `${appUrl}/retry-password-recovery.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 5000,
                        className: 'success',
                        close: true
                    }).showToast();
                    console.log(JSON.parse(response).message);

                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 5000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })

        });
        
        verificar.click(()=>{
            $.ajax({
                url: `${appUrl}/check-recovery.php`,
                data: { codigo: codigoEnviado.val() },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 5000,
                        className: 'success',
                        close: true
                    }).showToast();
                    console.log(JSON.parse(response).message);

                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 5000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })
        });

        $(document).ready(()=>{  
            $.ajax({
                url: `${appUrl}/password-recovery.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 5000,
                        className: 'success',
                        close: true
                    }).showToast();
                    console.log(JSON.parse(response).message);

                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 5000,
                        className: 'error',
                        close: true
                    }).showToast();
                }
            })
        })
    }
}