class AudioManager {
    playAsBgMusic  = function () {
        const audio = document.getElementById("game-sound");
        const audioIsEnabled = document.getElementById("audio-button").querySelector("img").src.includes("img/icons8-alto-falante-100.png");
        if(audio.paused && audioIsEnabled) {
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
            return;
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
        document.getElementById("audio-button").querySelector("img").src = "img/icons8-mute-64.png";
    }
    enableAudio = function () {
        const audio = document.getElementById("game-sound");
        audio.play();
        document.getElementById("audio-button").querySelector("img").src = "img/icons8-alto-falante-100.png";
    }
}