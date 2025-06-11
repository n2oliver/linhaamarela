class SpaceInvader {
    exibirHelpBox = false;
    DestruiuHelperBoxOptions = {
        NAO: 0,
        SIM: 1,
        NAO_SE_APLICA: 2,
    };
    destruiuHelperBox;
    totalDeMonstros = 0;

    init = function (enemyLevel) {
        const spaceInvaders = ['spaceinvaders-red', 'spaceinvaders-green', 'spaceinvaders-yellow', 'spaceinvaders-blue'];
        spaceInvader.destruiuHelperBox = spaceInvader.DestruiuHelperBoxOptions.NAO_SE_APLICA
        for (let i = 100 / enemyLevel; i < 100; i += (100 / enemyLevel)) {
            let invader = document.createElement('div');
            invader.classList.add("invader");
            invader.classList.add("unselectable");
            invader.style.left = i + "%";
            invader.style.top = "100px";
            invader.style.backgroundImage = "url(img/" + spaceInvaders[Math.floor(Math.random() * spaceInvaders.length)] + ".png)";
            document.body.append(invader);
        }
        spaceInvader.totalDeMonstros = document.querySelectorAll('.invader').length;
        window.game.setEvents(event);

        let left = true;
        return setInterval(function () {
            if (!window.pause) {
                for (let invader of document.getElementsByClassName('invader')) {
                    if (invader.offsetLeft > window.innerWidth - 64) {
                        left = false;
                    }
                    if (invader.offsetLeft < 0) {
                        left = true;
                    }
                    if (left == true) {
                        invader.style.left = (invader.offsetLeft + 10) + "px"
                    } else {
                        invader.style.left = (invader.offsetLeft - 10) + "px"
                    }
                    Array.from(document.body.children).filter((elem) => {
                        if (elem.nodeType == Node.ELEMENT_NODE && elem.classList.contains("capsule")
                            && (elem.offsetLeft < invader.offsetLeft + invader.clientWidth) &&
                            (elem.offsetLeft + elem.clientWidth > invader.offsetLeft)
                            &&
                            (elem.offsetTop < invader.offsetTop + invader.clientHeight) &&
                            (elem.offsetTop + elem.clientHeight > invader.offsetTop)
                        ) {
                            if(!invader.classList.contains('help-box')) {
                                invader.classList.add('anim-alien-die');
                                invader.classList.add('anim-alien-fall');
                                setTimeout(()=>{
                                    invader.remove();
                                    game.audioManager.playCreatureDie();
                                }, 1000);
                            } else {
                                invader.remove();
                            }
                            
                            window.game.pointsCounter.increaseCounter(5);

                            if(invader.classList.contains('help-box')) {
                                Object.assign(window.game.yellowBox.shotType, window.game.yellowBox.greatShotType);
                                game.audioManager.mudarParaLaser(game.audioManager.tipoLaser.forte);
                                setTimeout(()=>{
                                    Object.assign(window.game.yellowBox.shotType, window.game.yellowBox.defaultShotType);
                                    game.audioManager.mudarParaLaser(game.audioManager.tipoLaser.fraco);
                                }, 15000)
                            }
                            if ((document.querySelectorAll('.invader').length == 0 || document.querySelectorAll('.invader').length == spaceInvader.totalDeMonstros/2) && spaceInvader.destruiuHelperBox == spaceInvader.DestruiuHelperBoxOptions.NAO_SE_APLICA) {
                                spaceInvader.exibirHelpBox = true;
                                spaceInvader.destruiuHelperBox = spaceInvader.DestruiuHelperBoxOptions.NAO;

                                let invader = document.createElement('div');
                                invader.classList.add("invader");
                                invader.classList.add("help-box");
                                invader.classList.add("unselectable");
                                invader.style.left = "0%";
                                invader.style.top = "100px";
                                invader.style.backgroundImage = "url(img/apple.png)";
                                document.body.append(invader);
                            }
                        }
                    });
                }
                if (spaceInvader.exibirHelpBox && spaceInvader.destruiuHelperBox == spaceInvader.DestruiuHelperBoxOptions.NAO) {
                    spaceInvader.exibirHelpBox = false;
                }
            }
        }, 100);
    }
    destroy = function () {
        for (let invader of Object.assign([], document.getElementsByClassName("invader"))) {
            invader.remove()
        }
    }
}