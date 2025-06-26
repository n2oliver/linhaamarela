$(document).ready(() => {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let page = urlParams.get('page');
    let totalPaginas = 0;

    obterPontuacaoUsuario(page, usuarioId);
    paginar();

    function obterPontuacaoUsuario(page, idUsuario) {
        $('.spinner').removeClass('d-none');
        $.ajax({
            url: './obter-pontos.php',
            method: 'POST',
            type: 'json/application',
            data: { page: page || 1, id_usuario: idUsuario },
            success: (data) => {
                $('.spinner').addClass('d-none');
                const pontuacoes = JSON.parse(data);
                const pontosUsuario = $('#pontuacao');
                pontosUsuario.html('');
                for (pontuacao of pontuacoes) {
                    pontosUsuario.append(`<tr>
                                    <td>${pontuacao.posicao}</td>
                                    <td>${pontuacao.nome}</td>
                                    <td>${pontuacao.pontuacao}</td>
                                </tr>`);
                }
            },
            error: (error) => {
                $('.spinner').addClass('d-none');
                console.log(error.responseText);
            }
        });
    }
    function paginar(event) {
        let timer;
        clearTimeout(timer);
        timer = setTimeout(() => {
            $('.spinner').removeClass('d-none');
            if (event) event.preventDefault();
            if (event && event.target && event.target.innerText == 'Próximo') {
                if (page < totalPaginas) {
                    page++;
                }
            } else if (event && event.target && event.target.innerText == 'Anterior') {
                if (page > 1) {
                    page--;
                }
            } else {
                page = event && event.target ? event.target.innerText : 1;
            }
            urlParams.set('page', page);
            history.replaceState(null, '', `?${urlParams.toString()}`);


            $.ajax({
                url: './obter-pontos.php',
                method: 'POST',
                type: 'json/application',
                data: { page: page || 1 },
                success: (data) => {
                    $('.spinner').addClass('d-none');
                    const pontuacoes = JSON.parse(data);
                    const lista = $('#lista');
                    lista.html('');
                    for (pontuacao of pontuacoes) {
                        lista.append(`<tr>
                                            <td>${pontuacao.posicao}</td>
                                            <td>${pontuacao.nome}</td>
                                            <td>${pontuacao.pontuacao}</td>
                                        </tr>`);
                    }
                },
                error: (error) => {
                    $('.spinner').addClass('d-none');
                    console.log(error.responseText);
                }
            });
            $.ajax({
                url: './obter-paginacao.php',
                method: 'POST',
                type: 'json/application',
                data: { page: page },
                success: (response) => {
                    const dados = JSON.parse(response);
                    const paginas = $('#pagination');
                    paginas.html(dados.paginacao);
                    totalPaginas = dados.paginas;
                    $('.page-link').unbind('click').on('click', paginar);
                },
                error: (error) => {
                    console.log(error.responseText);
                }
            });
        }, 3000);
    }
});