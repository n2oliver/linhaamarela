class Game extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    yellowBox;
    invaderInterval;
    interval;
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
            positionY: "76",
            positionX: "50%",
            velocity: 1
        });

        this.yellowBox = new YellowBox({
            id: "yellow-box",
            width: 80,
            height: 8,
            color: "yellow",
            positionY: "60",
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
            var hammerBg = new Hammer(document.getElementById("bg-transparent"));
            var hammerYellowBox = new Hammer(document.getElementById("yellow-box"));

            hammerBg.on('pan', window.game.yellowBox.mouseMove);
            hammerYellowBox.on('pan', window.game.yellowBox.mouseMove);
            document.onmousemove = window.game.yellowBox.mouseMove;
            window.onmousedown = this.yellowBox.shot;
            window.onclick = null;
            window.pause = false;


            window.spaceInvader = new SpaceInvader();
            
            clearInterval(window.game.invaderInterval);
            this.invaderInterval = window.spaceInvader.init(parseInt((window.game.pointsCounter.points + 250) /250) * 5);

            $(".nivel").text("Nivel " + window.game.levelsCounter.level).show();
            setTimeout(()=> {
                $(".nivel").hide();
            }, 3000);

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
            
            this.interval = setInterval(() => {
                    if(document.onmousemove == window.game.yellowBox.mouseMove && document.getElementById(window.ball.attributes.id).offsetTop >= window.innerHeight - 90 &&
                        document.getElementById(window.ball.attributes.id).offsetTop <= window.innerHeight - 60){
                        window.game.pointsCounter.increaseCounter(5);
                        window.ball.attributes.velocity = window.game.levelsCounter.level;
                        window.game.levelsCounter.increaseCounter(window.game.pointsCounter.points, window.game.levelsCounter.level);
                    }
                    if(document.getElementById(window.ball.attributes.id).offsetTop > window.innerHeight) {
                        clearInterval(ballInterval);
                        if(window.game.invaderInterval) {
                            clearInterval(window.game.invaderInterval);
                        }
                        clearInterval(window.game.interval);
                        window.spaceInvader.destroy();
                        document.onmousemove = null;
                        
                        if(window.game.livesCounter.lives == 0) {
                            sessionStorage.setItem('ingame', false);
                            window.location = "gameover.html";
                            return;
                        }
                        game.livesCounter.decreaseCounter(1);
                        window.game = new Game(event, window.game.levelsCounter.level, window.game.pointsCounter.points, window.game.livesCounter.lives);
                        window.onclick = window.game.start;
                        
                    }
                }, 25);
        }
    };
}
