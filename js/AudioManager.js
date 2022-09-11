class AudioManager {
    playAsBgMusic  = function (audio) {
        if(audio.readyState && sessionStorage.musica == 'on') {
            audio.play();
            audio.onended = function() {
                audio.currentTime = 0;
                audio.play();
            }
        }
    }
    toggleAudio = function (audio) {
        if(sessionStorage.musica == 'on') {
            window.game.audioManager.disableAudio(audio);
            return;
        }
        window.game.audioManager.enableAudio(audio);
    }
    disableAudio = function (audio) {
        audio.pause();
        sessionStorage.setItem('musica', 'off');
        document.getElementById("audio-button").querySelector("img").src = "img/icons8-mute-64.png";
    }
    enableAudio = function (audio) {
        audio.play();
        sessionStorage.setItem('musica', 'on');
        document.getElementById("audio-button").querySelector("img").src = "img/icons8-alto-falante-100.png";
    }
}