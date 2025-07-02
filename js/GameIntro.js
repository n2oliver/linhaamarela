class GameIntro extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);
        
        this.start = (e) => {
            const login = new LoginRepository();
            const inscricao = new Inscricao();

            login.compilaLogin();
            inscricao.compilaInscricao();
        }
    };
}
