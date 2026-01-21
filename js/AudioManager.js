class AudioManager {
    constructor() {
        if(localStorage.mute == 'on') {
            document.getElementById("audio-button").querySelector("img").src = "/jogos/linhaamarela/img/icons8-mute-64.png";
        }
        this.mainMenuAudio = document.getElementById('main-menu-sound');
        if(this.mainMenuAudio) {
            document.body.onclick = () => {
                if(localStorage.mute != 'on') {
                    this.mainMenuAudio.play();
                    this.mainMenuAudio.onended = () => {
                        if(localStorage.mute != 'on') {
                            this.mainMenuAudio.play();
                        }
                    }
                    document.body.onclick = () => {}
                }
            }
        } else {
            this.shotAudio = document.getElementById("shot-audio");
            this.mudarParaLaser(this.tipoLaser.fraco);
            this.creatureDieAudio = document.getElementById("creature-die");
        }
    }
    mainMenuAudio;
    creatureDieAudio;
    shotAudio;
    tipoLaser = {
        forte: 'forte',
        fraco: 'fraco'
    }
    playShot = function () {
        if(localStorage.mute != 'on') {
            this.shotAudio.pause();
            this.shotAudio.currentTime = 0;
            this.shotAudio.play();
        }
    }
    playCreatureDie = function() {
        this.creatureDieAudio.pause();
        this.creatureDieAudio.currentTime = .25;
        this.creatureDieAudio.play();
    }
    mudarParaLaser(tipo) {
        this.shotAudio.src = `/jogos/linhaamarela/mp3/laser-${tipo}.mp3`;
    }
    playAsBgMusic  = function () {
        const audio = document.getElementById("game-sound");
        const audioIsEnabled = document.getElementById("audio-button").querySelector("img").src.includes("/jogos/linhaamarela/img/icons8-alto-falante-100.png");
        if(audio.paused && audioIsEnabled && localStorage.mute != 'on') {
            audio.play();
            audio.onended = function() {
                audio.currentTime = 0;
                audio.play();
            }
        }
    }
    toggleAudio = function () {
        const audio = document.getElementById("game-sound");
        if(window.pause) {
            window.game.audioManager.disableAudio(audio);
        }
        if(audio.paused) {
            window.game.audioManager.enableAudio(audio);
        } else {
            window.game.audioManager.disableAudio(audio);
        }
    }
    disableAudio = function () {
        const audio = document.getElementById("game-sound");
        audio.pause();
        document.getElementById("audio-button").querySelector("img").src = "/jogos/linhaamarela/img/icons8-mute-64.png";
        localStorage.setItem('mute', 'on');
    }
    enableAudio = function () {
        const audio = document.getElementById("game-sound");
        audio.play();
        audio.onended = function() {
            audio.currentTime = 0;
            audio.play();
        }
        document.getElementById("audio-button").querySelector("img").src = "/jogos/linhaamarela/img/icons8-alto-falante-100.png";
        localStorage.setItem('mute', 'off');
    }
}