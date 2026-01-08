let hammerBg;
let hammerYellowBox;
let hammerPlatform;
let hammerAudio;
let hammerPresentation;
class Game extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level = 1;
    yellowBox;
    invaderInterval;
    interval;
    audioManager;
    top = 100;
    constructor(e, level, totalDeMonstros, top, points, lives) {
        super(e, level, totalDeMonstros, top, points, lives);
        
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
            velocity: window.ball ? window.ball.attributes.velocity : 1
        });

        if(points) {
            this.pointsCounter.increaseCounter(points);
        }
        if(lives != null) {
            this.livesCounter.lives = lives;
        }

        this.audioManager = new AudioManager();
        window.gameOver = false;
    };
    yellowBox = new YellowBox({
        id: "yellow-box",
        width: 80,
        height: 40,
        positionY: "60",
        positionX: "50%"
    });
    platform = new Platform({
        id: "platform",
        width: "100vw",
        height: 80,
        positionY: 90,
        positionX: "0", 
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
                qrCodeStyle.display = "contents";
                pauseStyle.display = "contents";
                pauseButtonStyle.display = "none";
                playButtonStyle.display = "contents";
                audio.pause();
            } else {
                qrCodeStyle.display = "none";
                pauseStyle.display = "none";
                pauseButtonStyle.display = "contents";
                playButtonStyle.display = "none";
                const audioIsEnabled = document.getElementById("audio-button").querySelector("img").src.includes("/jogos/linhaamarela/img/icons8-alto-falante-100.png");
                if(audioIsEnabled) {
                    audio.play();
                }
            }
        }
    }
    start = (e) => {
        if(typeof window.gameOver != 'undefined' && window.gameOver === false) {
            window.game.setEvents(e);
            window.pause = false;


            window.spaceInvader = new SpaceInvader();
            window.spaceInvader.top = window.game.top;
            window.spaceInvader.totalDeMonstros = window.game.totalDeMonstros;
            
            clearInterval(window.game.invaderInterval);
            this.invaderInterval = window.spaceInvader.init(parseInt(window.game.level)*5);

            $(".nivel").text("Nivel " + window.game.levelsCounter.level).show();
            setTimeout(()=> {
                $(".nivel").hide();
            }, 3000);

            const ballInterval = window.ball.init(window.ball.attributes);
            
            this.interval = setInterval(() => {
                if(document.onmousemove == window.game.yellowBox.mouseMove && document.getElementById(window.ball.attributes.id).offsetTop >= window.innerHeight - 90 &&
                    document.getElementById(window.ball.attributes.id).offsetTop <= window.innerHeight - 60){
                    window.game.pointsCounter.increaseCounter(5);

                    if(document.querySelectorAll('.invader').length == 0 && !document.querySelector('.help-box')) {
                        window.ball.attributes.velocity = window.game.levelsCounter.level <= 11 ? window.game.levelsCounter.level : 11;
                        window.game.levelsCounter.increaseCounter(window.game.pointsCounter.points, window.game.levelsCounter.level);
                    }
                }
                if(document.getElementById(window.ball.attributes.id).offsetTop > window.innerHeight) {
                    clearInterval(ballInterval);
                    if(window.game.invaderInterval) {
                        clearInterval(window.game.invaderInterval);
                    }
                    clearInterval(window.game.interval);
                    window.spaceInvader.destroy();
                    document.onmousemove = null;
                    
                    game.livesCounter.decreaseCounter();
                    if(window.game.livesCounter.lives < 0) {
                        window.game.pointsCounter.points = 0;
                        window.game.levelsCounter.level = 0;
                        window.game.livesCounter.lives = 0;
                        sessionStorage.setItem('ingame', false);
                        if(typeof window.usuarioId !== 'undefined') {
                            window.location = "gameover.php";
                            return;
                        }
                        $('.heart').remove();
                        $('#game-over').removeClass('d-none');
                        window.gameOver = true;
                        const audioButton = document.getElementById("audio-button");
                        const audio = document.getElementById("game-sound");
                        audioButton.style.display = 'none';
                        audio.pause();

                    }
                    if(!window.gameOver) {
                        window.game = new Game(event, window.game.levelsCounter.level, window.spaceInvader.totalDeMonstros, window.spaceInvader.top, window.game.pointsCounter.points, window.game.livesCounter.lives);
                        window.onclick = window.game.start;
                    }
                    
                }
            }, 25);
        } else {
            clearInterval(this.interval);
            window.game.desabilitarEventos();
        }
    }
    setEvents = function (event) {
        window.game.yellowBox.updatePosition(event)
        hammerBg = new Hammer(document.getElementById("bg-transparent"));
        hammerYellowBox = new Hammer(document.getElementById("yellow-box"));
        hammerPlatform = new Hammer(document.getElementById("platform"));
        hammerAudio = new Hammer(document.getElementById("audio-button"));
        hammerBg.on('pan', window.game.yellowBox.mouseMove);
        hammerYellowBox.on('pan', window.game.yellowBox.mouseMove);
        hammerPlatform.on('pan', window.game.yellowBox.mouseMove);
        hammerAudio.on('pan', window.game.yellowBox.mouseMove);
        document.getElementById("audio-button").onclick = () => { 
            window.game.audioManager.toggleAudio();
        };

        const hammerPresentationElements = document.getElementsByClassName("unselectable");
        for(let presentation of hammerPresentationElements) {
            hammerPresentation = new Hammer(presentation);
            hammerPresentation.on('pan', window.game.yellowBox.mouseMove);
        }
        document.getElementById("pause").onclick = this.pause;
        document.getElementById("pause-button").onclick = this.pause;
        document.getElementById("play-button").onclick = this.pause;
        document.onmousemove = window.game.yellowBox.mouseMove;
        window.onmousedown = (event) => this.yellowBox.shot(event, this.yellowBox.shotType);
        window.onclick = null;
        window.onkeyup = this.pause;
    }
    
    desabilitarEventos = () => {

        // Desativa eventos globais
        document.onmousemove = null;
        window.onmousedown = null;
        window.onclick = null;
        window.onkeyup = null;
    }
}
            
window.onload = (e) => {
    sessionStorage.setItem('ingame', true);
    level = 1;
    game = new Game(e, level);
    document.getElementById("restart").addEventListener('click',()=>{
        gtag("event", "close_convert_lead", {
            currency: "USD",
            value: 0.0004
        });
        setTimeout(()=>{
            window.location.reload();
        }, 500);
    });
    abrirSmartlinkUmaVez();
}
window.onclick = (e) => {
    if(window.game) {
        window.game.audioManager.playAsBgMusic();
        game.start(e);
    }
}
