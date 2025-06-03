<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Linha Amarela</title>
        <meta charset="utf-8" />
        <meta name="viewport" 
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="preload" as="style" href="/jogos/linhaamarela/css/game.css" />
        <link rel="preload" as="image" href="/jogos/linhaamarela/img/eric-muhr-KrMhhUqdS-w-unsplash.jpg" />
        <link rel="preload" as="image" href="/jogos/linhaamarela/img/planicie.jpg" />
        <link rel="preload" as="image" href="/jogos/linhaamarela/img/island.jpg" />
        <link rel="preload" as="image" href="/jogos/linhaamarela/img/spaceinvaders-blue.png" />
        <link rel="preload" as="image" href="/jogos/linhaamarela/img/spaceinvaders-green.png" />
        <link rel="preload" as="image" href="/jogos/linhaamarela/img/spaceinvaders-red.png" />
        <link rel="preload" as="image" href="/jogos/linhaamarela/img/spaceinvaders-yellow.png" />
        <link rel="shortcut icon" href="/jogos/linhaamarela/iconlinhaamarela.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/logo.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/pause.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/audio.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/nivel.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/markers.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/enemies.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/game.css"></style>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles-index.css" />

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="/jogos/linhaamarela/js/vendor/hammer.min.js"></script>
        <script src="/jogos/linhaamarela/js/Background.js"></script>
        <script src="/jogos/linhaamarela/js/Counter.js"></script>
        <script src="/jogos/linhaamarela/js/PointsCounter.js"></script>
        <script src="/jogos/linhaamarela/js/LevelsCounter.js"></script>
        <script src="/jogos/linhaamarela/js/LivesCounter.js"></script>
        <script src="/jogos/linhaamarela/js/GameObject.js"></script>
        <script src="/jogos/linhaamarela/js/YellowBox.js"></script>
        <script src="/jogos/linhaamarela/js/Ball.js"></script>
        <script src="/jogos/linhaamarela/js/SpaceInvader.js"></script>
        <script src="/jogos/linhaamarela/js/AudioManager.js"></script>
        <script src="/jogos/linhaamarela/js/GameBase.js"></script>
        <script src="/jogos/linhaamarela/js/Game.js"></script>
        <style>
            .menu {
                height: 64px;
                display: inline-flex;
                flex-wrap: nowrap;
                justify-content: flex-start;
                float: right;
                padding: 20px 20px 0 20px;
            }
            .markers {
                display: list-item !important;
                padding: 20px 20px 0 20px;
            }
        </style>
    </head>
    <body>
        <audio id="game-sound" src="/jogos/linhaamarela/mp3/residence-tatami-main-version.mp3" controls style="display: none" preload="auto"></audio>
        <div id="bg-transparent" style="width: 100%; height: 100%; position: fixed; z-index: -1;"></div>    
        
        <div class="menu">
            <div id="logo" class="unselectable game-logo"><img src="/jogos/linhaamarela/img/logo-linhaamarela.png"/></div>
        </div>
        <div class="menu">
            <div id="pause-button" class="unselectable pause-button menu-item"><img src="/jogos/linhaamarela/img/pause-icon-png-12.jpg"/></div>
            <div id="play-button" class="unselectable play-button menu-item"><img src="/jogos/linhaamarela/img/png-clipart-digital-marketing-implementation-business-computer-programming-play-button-electronics-text.png"/></div>
            <div id="audio-button" class="unselectable audio-button menu-item"><img width="100%" src="/jogos/linhaamarela/img/icons8-alto-falante-100.png"/></div>
        </div>
        <div class="menu-item markers">
            <div class="presentation-container unselectable">Nivel: <span id="levels-counter">1</span></div>
            <div class="presentation-container unselectable">Pontos: <span id="points-counter">0</span></div>
            <div class="presentation-container unselectable">Vidas restantes: <span id="vidas">2</span></div>
        </div>
        <div id="qr-code" style="display: none; color: white;" class="qr-code rotate-center">
            <div style="display: flex; justify-content: space-around; align-content: center;">
                <div>
                    <div>Aceitamos doações:</div>
                    <div>Chave PIX:</div>
                    <div><img src="/jogos/linhaamarela/img/qrcode-pix.png"/></div>
                    <div>silva.liver@gmail.com</div>
                </div>
                <div>
                    <script async="async" data-cfasync="false" src="//pl26829990.profitableratecpm.com/c36f214a2069f40ccd2d3e53c3c624b7/invoke.js"></script>
                    <div id="container-c36f214a2069f40ccd2d3e53c3c624b7"></div>
                </div>
            </div>
        </div>
        <div id="nivel" class="nivel unselectable rotate-center">Nivel</div>
        <div id="red-ball"></div>
        <div id="yellow-box"></div>
        <div id="pause" class="pause unselectable rotate-center">Pause</div>
        <audio id="toque-linha-amarela" src="/jogos/linhaamarela/mp3/toque-linha-amarela.mp3" controls autoplay="false" style="display: none"></audio>
        <div class="mt-2" style="display: block; width: 100vw; position: absolute; bottom: -114px; text-align: center; color: white; padding: 24px; background-image: linear-gradient(transparent,#000000, #000000, #000000);">
            <div style="margin: 0 auto">
                <script type="text/javascript">
                    atOptions = {
                        'key' : '36908cd1702faba6c183fb82dc5a6c78',
                        'format' : 'iframe',
                        'height' : 60,
                        'width' : 468,
                        'params' : {}
                    };
                </script>
                <script type="text/javascript" src="//www.highperformanceformat.com/36908cd1702faba6c183fb82dc5a6c78/invoke.js"></script>
            </div>
            <a href="/"><span style="font-family: Montserrat">Oliv3r Dev</span></a>
            <span style="font-size: 9px">Todos os direitos reservados - Oliv3r Dev -  2025</span>
            <span style="font-size: 9px">CNPJ 60.407.027/0001-25</span>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>