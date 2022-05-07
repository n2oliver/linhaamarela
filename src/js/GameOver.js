class GameOver extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);

        const yellowBox = new YellowBoxNPC({
            id: "yellow-box",
            width: 80,
            height: 8,
            color: "yellow",
            strokeColor: "#000",
            strokeStyle: "solid",
            strokeDepth: "2px",
            position: "fixed",
            positionY: "120",
            positionX: "50%"
        });

        this.start = (e) => {
            document.onmousemove = yellowBox.mouseMove;
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
