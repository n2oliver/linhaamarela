class GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        this.level = level;
        let background;

        background = new Background();
        
        window.ball = new Ball({
            id: "red-ball",
            supportBarId: "yellow-box",
            width: 16,
            height: 16,
            color: "red",
            strokeColor: "#000",
            strokeStyle: "solid",
            strokeDepth: "1px",
            position: "fixed",
            positionY: "136",
            positionX: "50%",
            velocity: 1
        });

        background.set("img/planicie.jpg");
    
        window.ball.build(window.ball.attributes);
    };
}
