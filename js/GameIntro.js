class GameIntro extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);
        
        window.ball = new BallNPC({
            id: "red-ball",
            supportBarId: "yellow-box",
            width: 16,
            height: 16,
            color: "red",
            strokeColor: "#000",
            strokeStyle: "solid",
            strokeDepth: "1px",
            position: "fixed",
            positionY: "76",
            positionX: "50%",
            velocity: 1
        });

        window.ball.build(window.ball.attributes);

        const yellowBox = new YellowBoxNPC({
            id: "yellow-box",
            width: 80,
            height: 8,
            color: "yellow",
            strokeColor: "#000",
            strokeStyle: "solid",
            strokeDepth: "2px",
            position: "fixed",
            positionY: "60",
            positionX: "50%"
        });

        this.start = (e) => {
            document.onmousemove = yellowBox.mouseMove;

            const submitButton = document.getElementById("submit-inscricao");
            const usernameField = document.getElementById("username");
            const passwordField = document.getElementById("password");

            const inscricao = new Inscricao();
            inscricao.compilaInscricao();

            window.ball.init(window.ball.attributes);
            const interval = function () {
                setInterval(() => {
                    yellowBox.updatePosition()
                }, 25);
            }
            
            interval();
        }
    };
}
