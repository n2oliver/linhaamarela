class GameOver extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);

        this.start = async (e) => {
            PointsCounter.getHighScores().then(data => {
                for(let index in data.body.scores) {
                    const points = data.body.scores[index];
                    const position =parseInt(index) + 1;
                    if(points.usuario_id == sessionStorage.userId) {
                        $('#your-points tbody').append(
                            `<tr>
                                <td class="presentation text-warning"><a href="#posicao">#${position}</a></td><td>${points.nomedeusuario}</td><td>${sessionStorage.pontuacao || 0} pontos</td><td>${points.pontuacao} pontos</td>
                            </tr>`);
                        console.log('YOU:', points);
                    }
                    $('#all-points tbody').append(
                        `<tr>
                            <td><a id="posicao" href="#posicao">#${position}</a></td><td>${points.nomedeusuario}</td><td>${points.pontuacao} pontos</td>
                        </tr>`);
                    console.log(points);
                }
            }).catch(error => {
                console.log(error);
            });
            window.spaceInvaderNpc = new SpaceInvaderNPC();
            this.invaderInterval = window.spaceInvaderNpc.init();
        }
    };
}
