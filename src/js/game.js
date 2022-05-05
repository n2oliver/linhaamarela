class Game extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);

        const yellowBox = new YellowBox({
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
        if(lives) {
            this.livesCounter.lives = lives;
        }

        this.start = (e) => {
            document.onmousemove = yellowBox.mouseMove;
            window.onclick = null;
            const ballInterval = window.ball.init(window.ball.attributes);
            const interval = function () {
                setInterval(() => {
                    if(document.onmousemove == yellowBox.mouseMove && document.getElementById(window.ball.attributes.id).offsetTop >= window.innerHeight - 150 &&
                        document.getElementById(window.ball.attributes.id).offsetTop <= window.innerHeight - 120){
                        window.game.pointsCounter.increaseCounter(5);
                        window.ball.attributes.velocity = window.game.levelsCounter.level;
                        window.game.levelsCounter.increaseCounter(window.game.pointsCounter.points);
                    }
                    if(document.getElementById(window.ball.attributes.id).offsetTop > window.innerHeight) {
                        clearInterval(ballInterval);
                        clearInterval(interval);
                        document.onmousemove = null;
                        
                        game.livesCounter.decreaseCounter(1);
                        window.game = new Game(event, window.game.levelsCounter.level, window.game.pointsCounter.points, window.game.livesCounter.lives);
                        window.onclick = window.game.start;
                        
                    }
                }, 25);
            }
            let gameInterval = interval;
            
            gameInterval();
            
        }
    };
}
