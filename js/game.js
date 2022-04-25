class Game {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points) {
        this.level = level;
        let background, yellowBox;

        background = new Background();

        yellowBox = new YellowBox({
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


        this.pointsCounter = new PointsCounter({
            id: "points-counter",
            points: 0,
        });

        if(points) {
            this.pointsCounter.increaseCounter(points);
        }

        this.levelsCounter = new LevelsCounter({
            id: "levels-counter",
        });
        
        this.livesCounter = new LivesCounter({
            id: "vidas",
        });

        this.start = (e) => {
            let mouseMove = (e) => {
                yellowBox.updatePosition(e, yellowBox);
            }
            window.onclick = null;
            const ballInterval = window.ball.init(window.ball.attributes);
            document.onmousemove = mouseMove;
            const interval = function () {
                setInterval(() => {
                    if(document.onmousemove == mouseMove && document.getElementById(window.ball.attributes.id).offsetTop >= window.innerHeight - 150 &&
                        document.getElementById(window.ball.attributes.id).offsetTop <= window.innerHeight - 120){
                        window.game.pointsCounter.increaseCounter(5);
                        window.ball.attributes.velocity = window.game.levelsCounter.level;
                        window.game.levelsCounter.increaseCounter(window.game.pointsCounter.points);
                        return;
                    }
                    if(document.getElementById(window.ball.attributes.id).offsetTop > window.innerHeight) {
                        clearInterval(ballInterval);
                        clearInterval(interval);
                        document.onmousemove = null;
                        
                        game.livesCounter.decreaseCounter(1);
                        window.game = new Game(event, window.game.levelsCounter.level, window.game.pointsCounter.points);
                        window.onclick = window.game.start;
                        
                    }
                }, 25);
            }
            let gameInterval = interval;
            
            gameInterval();
            
        }
    };
}
