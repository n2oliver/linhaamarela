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
            var hammertime = new Hammer(document.body);
            window.spaceInvader = new SpaceInvader();
            hammertime.on('panmove', window.game.yellowBox.mouseMove);
            document.onmousemove = window.game.yellowBox.mouseMove;
            window.onmousedown = this.yellowBox.shot;
            window.onclick = null;
            window.pause = false;

            const invaderInterval = window.spaceInvader.init(parseInt((window.game.pointsCounter.points + 250) /250) * 5);
            window.onkeyup = function(e) {
                if(e.keyCode == 27) {
                    if(window.pause) {
                        window.pause = false;
                    } else {
                        window.pause = true
                    }
                    const pauseStyle = document.getElementById("pause").style;
                    if(window.pause) {
                        pauseStyle.display = "block";
                    } else {
                        pauseStyle.display = "none";
                    }
                }
            }
            const ballInterval = window.ball.init(window.ball.attributes);
            
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
                        if(invaderInterval) {
                            clearInterval(invaderInterval);
                        }
                        clearInterval(interval);
                        window.spaceInvader.destroy();
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
