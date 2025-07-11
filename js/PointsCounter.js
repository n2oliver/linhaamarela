class PointsCounter extends Counter {
    points = 0;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            top: "64px",
            left: "32px"
        }
        Object.assign(document.getElementById(attributes.id).parentElement.style, styles);

        this.increaseCounter = (points) => {
            clearTimeout(this.timer);
            this.points += parseInt(points);
            document.getElementById(this.attributes.id).innerText = this.points;
            if(typeof usuarioId !== 'undefined') {
                this.timer = setTimeout(() => {
                    if(!window.partidaRapida && usuarioId) {
                        $.ajax({
                            url: './registrar-pontos.php',
                            method: 'POST',
                            type: 'json/application',
                            data: { pontos: this.points, nivel: window.game.level },
                            success: (data)=>{
                                sessionStorage.setItem('pontuacao', this.points);
                                sessionStorage.setItem('nivel', window.game.level);
                                $.ajax({
                                    url: './obter-pontos.php',
                                    method: 'POST',
                                    type: 'json/application',
                                    data: { page: 1 },
                                    success: (data)=>{
                                        sessionStorage.setItem('pontuacao', this.points);
                                        sessionStorage.setItem('nivel', window.game.level);
                                        obterRanking(usuarioId);
                                    },
                                    error: (error)=>{
                                        console.log(error.responseText);
                                    }
                                });
                            },
                            error: (error)=>{
                                console.log(error.responseText);
                            }
                        });
                    } else {
                        sessionStorage.setItem('pontuacao', this.points);
                        sessionStorage.setItem('nivel', window.game.level);
                    }
                },1000); 
            }
        }
    }
    static getHighScores = async (page) => {
        const params = { userId: sessionStorage.userId };
        if(page) {
            params.page = page;
        }
        return $.ajax({
            url: '/obter-pontos',
            method: 'GET',
            type: 'json/application',
            data: params,
        }).done((data)=>{
            return data;
        }).fail((error)=>{
            return error;
        });
    }
}