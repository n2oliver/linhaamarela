class GameOver extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);

        this.start = async (e) => {
            PointsCounter.getHighScores().then(listScores).catch(error => {
                console.log(error);
            });
            window.spaceInvaderNpc = new SpaceInvaderNPC();
            this.invaderInterval = window.spaceInvaderNpc.init();
        }
    };
}
function listScores (data) {
    const yourPoints = data.body.scores.userHighScore;
    if(yourPoints) {
        $('#your-points tbody').html("").append(
            `<tr>
                <td class="presentation text-warning"><a href="#posicao">#${yourPoints.posicao}</a></td><td>${sessionStorage.username}</td><td class="pontuacao">${sessionStorage.pontuacao || 0} pontos</td><td class="recorde">${yourPoints.pontuacao} pontos</td>
            </tr>`);
    }

    $('#all-points tbody').html("");
    for(let index in data.body.scores.rows) {
        const points = data.body.scores.rows[index];
        const page = data.page || 0;
        const position =parseInt((page*10)+parseInt(index)) + 1;
        $('#all-points tbody').append(
            `<tr>
                <td><a id="posicao" href="#posicao">#${position}</a></td><td>${points.nomedeusuario}</td><td>${points.pontuacao} pontos</td>
            </tr>`);
        console.log(points);
    }
    $('#pagination').html("");
    if(data.body.scores.prev != -1) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" data-page="${data.body.scores.prev}">Anterior</a></li>`);
    }
    for(let i=0; i < data.body.scores.pages; i++) {
        if(i > 1) {
            $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" data-page="${i-1}">${i}</a></li>`);
        }
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i+1}</a></li>`);
        if(i+2 < data.body.scores.pages) {
            $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" data-page="${i+1}">${i+2}</a></li>`);
        }
    }
    if(data.body.scores.next != data.body.scores.pages) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" data-page="${data.body.scores.next}">Próximo</a></li>`);
    }
    $('.page-link').on('click', (e) => {
        const page = $(e.target).data("page");
        PointsCounter.getHighScores(page).then((data) => {
            data.page = page;
            listScores(data);
        }).catch(error => {
            console.log(error);
        });
    });
    $('#compartilhar').click(function() {
        share();
    });
}