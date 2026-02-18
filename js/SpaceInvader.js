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
        spaceInvader.destruiuHelperBox = spaceInvader.DestruiuHelperBoxOptions.NAO_SE_APLICA;
        let levelTop = 1;
        let usedHeights = [];

        let left = true;
        const fragment = document.createDocumentFragment(); // Use a document fragment for better performance

        // Define quantidade inicial fixa e progressão baseada no nível
        const initialEnemies = 5; // Quantidade inicial fixa
        const progressiveEnemies = Math.min(initialEnemies + enemyLevel, 50); // Limita o máximo de inimigos

        for (let i = 0; i < progressiveEnemies; i++) {
            // Gera posições aleatórias para os inimigos
            let invaderTop;
            let attempts = 0; // Limita tentativas para evitar loops infinitos
            do {
                invaderTop = Math.floor(Math.random() * (window.innerHeight - 200)) + 100; // Altura aleatória dentro dos limites
                attempts++;
            } while (usedHeights.some(height => Math.abs(height - invaderTop) < 50) && attempts < 100);

            if (attempts < 100) {
                usedHeights.push(invaderTop);

                let invader = document.createElement('div');
                invader.classList.add("invader");
                invader.classList.add("unselectable");
                invader.style.left = (left ? '-' : '') + (Math.random() * 90 + 5) + "%"; // Posição horizontal aleatória
                invader.style.top = invaderTop + "px";
                invader.style.backgroundImage = "url(img/" + spaceInvaders[Math.floor(Math.random() * spaceInvaders.length)] + ".png)";
                fragment.appendChild(invader); // Adiciona ao fragmento
            }
        }

        document.body.appendChild(fragment); // Adiciona todos os inimigos ao DOM de uma vez

        spaceInvader.totalDeMonstros = document.querySelectorAll('.invader').length;
        window.game.setEvents(event);
        setInterval(() => {
            left = !left;
        }, 5000);

        let interval = setInterval(function () {
            if (!window.pause) {
                if (document.querySelectorAll('.invader').length == 0) {
                    window.ball.attributes.velocity = window.game.levelsCounter.level <= 11 ? window.game.levelsCounter.level : 11;
                    window.game.levelsCounter.increaseCounter(window.game.pointsCounter.points, window.game.levelsCounter.level);
                }
                for (let invader of document.getElementsByClassName('invader')) {
                    if (invader.offsetLeft > window.innerWidth - 64) {
                        left = false;
                    }
                    if (invader.offsetLeft < 0) {
                        left = true;
                    }

                    // Alterações nos movimentos a cada 10 níveis
                    if (enemyLevel >= 10 && enemyLevel % 10 === 0) {
                        // Movimento em zigue-zague
                        invader.style.left = (invader.offsetLeft + (left ? 15 : -15)) + "px";
                        invader.style.top = (invader.offsetTop + (Math.random() > 0.5 ? 10 : -10)) + "px";
                    } else if (enemyLevel >= 20 && enemyLevel % 10 === 0) {
                        // Movimento circular
                        let angle = (Date.now() / 100) % 360;
                        invader.style.left = (invader.offsetLeft + Math.sin(angle) * 10) + "px";
                        invader.style.top = (invader.offsetTop + Math.cos(angle) * 10) + "px";
                    } else {
                        // Movimento padrão
                        invader.style.left = (invader.offsetLeft + (left ? 10 : -10)) + "px";
                    }

                    // Movimento vertical com translateY
                    let translateY = invader.dataset.direction === "down" ? 5 : -5;
                    let currentTransform = invader.style.transform.match(/translateY\((-?\d+)px\)/);
                    let currentY = currentTransform ? parseInt(currentTransform[1]) : 0;
                    invader.style.transform = `translateY(${currentY + translateY}px)`;

                    // Inverte direção vertical se ultrapassar limites
                    if (currentY + translateY > 50 || currentY + translateY < -50) {
                        invader.dataset.direction = invader.dataset.direction === "down" ? "up" : "down";
                    }

                    Array.from(document.body.children).filter((elem) => {
                        if (
                            elem.nodeType == Node.ELEMENT_NODE &&
                            (elem.classList.contains("capsule") || elem.classList.contains("red-ball")) &&
                            elem.offsetLeft < invader.offsetLeft + invader.clientWidth &&
                            elem.offsetLeft + elem.clientWidth > invader.offsetLeft &&
                            elem.offsetTop < invader.offsetTop + invader.clientHeight &&
                            elem.offsetTop + elem.clientHeight > invader.offsetTop
                        ) {
                            if (!invader.classList.contains('help-box')) {
                                invader.classList.add('anim-alien-die');
                                invader.classList.add('anim-alien-fall');
                                setTimeout(() => {
                                    invader.remove();

                                    if (localStorage.mute == 'off') {
                                        game.audioManager.playCreatureDie();
                                    }
                                }, 1000);
                            } else {
                                window.game.livesCounter.increaseCounter();
                                invader.remove();
                            }

                            window.game.pointsCounter.increaseCounter(5);

                            if (invader.classList.contains('help-box')) {
                                Object.assign(window.game.yellowBox.shotType, window.game.yellowBox.greatShotType);
                                game.audioManager.mudarParaLaser(game.audioManager.tipoLaser.forte);
                                setTimeout(() => {
                                    Object.assign(window.game.yellowBox.shotType, window.game.yellowBox.defaultShotType);
                                    game.audioManager.mudarParaLaser(game.audioManager.tipoLaser.fraco);
                                }, 15000);
                            }
                            if (
                                (document.querySelectorAll('.invader').length == 0 ||
                                    document.querySelectorAll('.invader').length ==
                                        parseInt(spaceInvader.totalDeMonstros / 2)) &&
                                spaceInvader.destruiuHelperBox ==
                                    spaceInvader.DestruiuHelperBoxOptions.NAO_SE_APLICA
                            ) {
                                spaceInvader.exibirHelpBox = true;
                                spaceInvader.destruiuHelperBox =
                                    spaceInvader.DestruiuHelperBoxOptions.NAO;

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
                if (
                    spaceInvader.exibirHelpBox &&
                    spaceInvader.destruiuHelperBox == spaceInvader.DestruiuHelperBoxOptions.NAO
                ) {
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