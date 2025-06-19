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
                    duration: 3000
                }).showToast();
                setTimeout(()=>{
                    window.location.href=`${appUrl}/game.php`;
                }, 3000);

            },
            error: (xhr) => {
                Toastify({
                    text: JSON.parse(xhr.responseText).error,
                    duration: 3000,
                    className: 'error'
                }).showToast();
            }
        })
    }
    passwordRecovery = () => {
        const appUrl = '/jogos/linhaamarela'
        const email = $('#email').val();
        const campoSenha = $('#campo-senha');
        const codigoEmail = $('#codigo-email');
        const naoRecebiEmail = $('#nao-recebi');

        if(!email.trim()) {
            Toastify({
                text: "Preencha primeiro o campo email!",
                duration: 3000,
                className: 'error'
            }).showToast();
            return;
        }
        campoSenha.addClass('d-none');
        codigoEmail.removeClass('d-none');
        naoRecebiEmail.removeClass('d-none');
        naoRecebiEmail.click(()=>{
            $.ajax({
                url: `${appUrl}/retry-password-recovery.php`,
                data: { email },
                type: 'POST',
                success: (response) => {
                    Toastify({
                        text: JSON.parse(response).data,
                        duration: 3000,
                        className: 'success'
                    }).showToast();
                    console.log(JSON.parse(response).message);

                },
                error: (xhr) => {
                    Toastify({
                        text: JSON.parse(xhr.responseText).error,
                        duration: 3000,
                        className: 'error'
                    }).showToast();
                }
            })

        })

        $.ajax({
            url: `${appUrl}/password-recovery.php`,
            data: { email },
            type: 'POST',
            success: (response) => {
                Toastify({
                    text: JSON.parse(response).data,
                    duration: 3000,
                    className: 'success'
                }).showToast();
                console.log(JSON.parse(response).message);

            },
            error: (xhr) => {
                Toastify({
                    text: JSON.parse(xhr.responseText).error,
                    duration: 3000,
                    className: 'error'
                }).showToast();
            }
        })
    }
}