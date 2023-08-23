class GameIntro extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);
        
        this.start = (e) => {
            const login = new Login();
            const inscricao = new Inscricao();

            login.compilaLogin();
            inscricao.compilaInscricao();
        }
    };
}
