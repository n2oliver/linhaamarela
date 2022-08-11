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

        if(points) {
            this.pointsCounter.increaseCounter(points);
        }
        if(lives != null) {
            this.livesCounter.lives = lives;
        }
    };
    yellowBox = new YellowBox({
        id: "yellow-box",
        width: 80,
        height: 8,
        color: "yellow",
        positionY: "60",
        positionX: "50%"
    });
    pointsCounter = new PointsCounter({
        id: "points-counter",
        points: 0,
    });
    levelsCounter = new LevelsCounter({
        id: "levels-counter",
    });
    livesCounter = new LivesCounter({
        id: "vidas",
    });
    pause = function(e) {
        let validation;
        if(e.type == "keyup") {
            validation = e.keyCode == 27;
        } else {
            validation = true;
        }
        
        if(validation) {
            if(window.pause) {
                window.pause = false;
            } else {
                window.pause = true
            }
            const qrCodeStyle = document.getElementById("qr-code").style;
            const pauseStyle = document.getElementById("pause").style;
            const playButtonStyle = document.getElementById("play-button").style;
            const pauseButtonStyle = document.getElementById("pause-button").style;
            const audio = document.getElementById("game-sound");
            if(window.pause) {
                qrCodeStyle.display = "block";
                pauseStyle.display = "block";
                pauseButtonStyle.display = "none";
                playButtonStyle.display = "block";
                audio.pause();
            } else {
                qrCodeStyle.display = "none";
                pauseStyle.display = "none";
                pauseButtonStyle.display = "block";
                playButtonStyle.display = "none";
                
                if(sessionStorage.musica == 'on') {
                    audio.play();
                }
            }
        }
    }
    start = (e) => {
        window.game.setEvents();
        window.pause = false;


        window.spaceInvader = new SpaceInvader();
        
        clearInterval(window.game.invaderInterval);
        this.invaderInterval = window.spaceInvader.init(parseInt((window.game.pointsCounter.points + 250) /250) * 5);

        $(".nivel").text("Nivel " + window.game.levelsCounter.level).show();
        setTimeout(()=> {
            $(".nivel").hide();
        }, 3000);

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
    setEvents = function () {
        var hammerBg = new Hammer(document.getElementById("bg-transparent"));
        var hammerYellowBox = new Hammer(document.getElementById("yellow-box"));
        var hammerAudio = new Hammer(document.getElementById("audio-button"));
        hammerBg.on('pan', window.game.yellowBox.mouseMove);
        hammerYellowBox.on('pan', window.game.yellowBox.mouseMove);
        hammerAudio.on('tap', window.game.toggleAudio);

        var hammerPresentationElements = document.getElementsByClassName("unselectable");
        for(let presentation of hammerPresentationElements) {
            const hammerPresentation = new Hammer(presentation);
            hammerPresentation.on('pan', window.game.yellowBox.mouseMove);
        }
        document.getElementById("pause").onclick = this.pause;
        document.getElementById("pause-button").onclick = this.pause;
        document.getElementById("play-button").onclick = this.pause;
        document.getElementById("audio-button").onclick = this.toggleAudio;
        document.onmousemove = window.game.yellowBox.mouseMove;
        window.onmousedown = this.yellowBox.shot;
        window.onclick = null;
        window.onkeyup = this.pause;
    }
    disableAudio = function () {
        const audio = document.getElementById("game-sound");
        audio.pause();
        sessionStorage.setItem('musica', 'off');
        document.getElementById("audio-button").querySelector("img").src = "img/icons8-mute-64.png";
    }
    enableAudio = function () {
        const audio = document.getElementById("game-sound");
        audio.play();
        sessionStorage.setItem('musica', 'on');
        document.getElementById("audio-button").querySelector("img").src = "img/icons8-alto-falante-100.png";
    }
    toggleAudio = function (e, game = window.game) {
        if(sessionStorage.musica == 'on') {
            game.disableAudio();
        } else {
            game.enableAudio();
        }
    }
}

window.game;
            
window.onload = (e) => {
    const loggedUser = document.cookie.split(";").map((entry)=> {
        const values = entry.split("=");
        const key = values[0];
        const value = values[1];
        return {
            key: key,
            value: value
        }
    }).filter((entry) => { if(entry.key.trim() == "username") return entry });
    if(loggedUser < 1) {
        window.location = "index.html";
    }
    level = 1;
    game = new Game(e, level);
}
window.onclick = (e) => {
    const audio = document.getElementById("game-sound");
    if(audio.readyState) {
        if(sessionStorage.musica == 'on') {
            audio.play();
            audio.onended = function() {
                audio.currentTime = 0;
                audio.play();
            }
        }
    }
    game.start(e);
}
