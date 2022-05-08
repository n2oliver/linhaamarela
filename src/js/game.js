class Game extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    yellowBox;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);
        
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
        
        window.ball.build(window.ball.attributes);

        this.yellowBox = new YellowBox({
            id: "yellow-box",
            width: 80,
            height: 8,
            color: "yellow",
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
        if(lives != null) {
            this.livesCounter.lives = lives;
        }

        this.start = (e) => {
            document.onmousemove = window.game.yellowBox.mouseMove;
            window.onmousedown = this.yellowBox.shot;
            window.onclick = null;
            const ballInterval = window.ball.init(window.ball.attributes);

            const enableGesture = function() {
                var containerElement = document;
                var activeRegion = ZingTouch.Region(containerElement);
                var childElement = document.body;
                activeRegion.bind(childElement, 'pan', function(event){
                    console.log(event);
                });
            }
            enableGesture();
            
            const interval = function () {
                setInterval(() => {
                    if(document.onmousemove == window.game.yellowBox.mouseMove && document.getElementById(window.ball.attributes.id).offsetTop >= window.innerHeight - 150 &&
                        document.getElementById(window.ball.attributes.id).offsetTop <= window.innerHeight - 120){
                        window.game.pointsCounter.increaseCounter(5);
                        window.ball.attributes.velocity = window.game.levelsCounter.level;
                        window.game.levelsCounter.increaseCounter(window.game.pointsCounter.points);
                    }
                    if(document.getElementById(window.ball.attributes.id).offsetTop > window.innerHeight) {
                        clearInterval(ballInterval);
                        clearInterval(interval);
                        document.onmousemove = null;
                        
                        if(window.game.livesCounter.lives == 0) {
                            window.location = "gameover.html";
                            return;
                        }
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
