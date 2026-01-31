class SpaceInvader {
    exibirHelpBox = false;
    DestruiuHelperBoxOptions = {
        NAO: 0,
        SIM: 1,
        NAO_SE_APLICA: 2,
    };
    destruiuHelperBox;
    totalDeMonstros = 0;
    top = 100;
    novaLinhaTimer = 0;

    init = function (enemyLevel) {
        const spaceInvaders = ['spaceinvaders-red', 'spaceinvaders-green', 'spaceinvaders-yellow', 'spaceinvaders-blue'];
        spaceInvader.destruiuHelperBox = spaceInvader.DestruiuHelperBoxOptions.NAO_SE_APLICA
        let levelTop = 1;


        let left = true;
        for (let i = 100 / enemyLevel; i < 100; i += (100 / enemyLevel)) {
            if((i == 100 / enemyLevel) || 
                ((spaceInvader.totalDeMonstros * (100 / enemyLevel))
                    - (100 / enemyLevel)) * 64 > window.innerWidth / 2) {
                spaceInvader.novaLinhaTimer++;
                if(spaceInvader.novaLinhaTimer > window.innerWidth / 64 / 7) {
                    levelTop++;
                    spaceInvader.top = 100 * levelTop;
                    spaceInvader.novaLinhaTimer = 0;
                }
            }
            if(spaceInvader.top > window.innerHeight - (window.game.yellowBox.attributes.positionY * 2)) {
                spaceInvader.top = 100;
            }
            let invader = document.createElement('div');
            invader.classList.add("invader");
            invader.classList.add("unselectable");
            invader.style.left = (left ? '-' : '') + i + "%";
            invader.style.top = spaceInvader.top + "px";
            invader.style.backgroundImage = "url(img/" + spaceInvaders[Math.floor(Math.random() * spaceInvaders.length)] + ".png)";
            document.body.append(invader);
        }
        spaceInvader.totalDeMonstros = document.querySelectorAll('.invader').length;
        window.game.setEvents(event);
        setInterval(()=>{       
            if (left == true) {
                left = false;
            } else {
                left = true;
            }
        }, 5000);
        let interval = setInterval(function () {
            if (!window.pause) {
                let direction = 1;
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

                                    if(localStorage.mute == 'off') {
                                        game.audioManager.playCreatureDie();
                                    }
                                    if(document.querySelectorAll('.invader').length == 0) {
                                        window.ball.attributes.velocity = window.game.levelsCounter.level <= 11 ? window.game.levelsCounter.level : 11;
                                        window.game.levelsCounter.increaseCounter(window.game.pointsCounter.points, window.game.levelsCounter.level);
                                    }
                                }, 1000);
                            } else {
                                window.game.livesCounter.increaseCounter();
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
                            if ((document.querySelectorAll('.invader').length == 0 || document.querySelectorAll('.invader').length == parseInt(spaceInvader.totalDeMonstros/2)) && spaceInvader.destruiuHelperBox == spaceInvader.DestruiuHelperBoxOptions.NAO_SE_APLICA) {
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
        return interval;
    }
    destroy = function () {
        for (let invader of Object.assign([], document.getElementsByClassName("invader"))) {
            invader.remove()
        }
    }
}