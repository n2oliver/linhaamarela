<?php 
$APP_URL = '/jogos/linhaamarela';
require('./database/connectdb.php');
require('./verifica-login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Linha Amarela</title>
        <meta charset="utf-8" />
        <meta name="viewport" 
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="preload" as="style" href="<?= $APP_URL ?>/css/game.css" />
        <link rel="preload" as="image" href="<?= $APP_URL ?>/img/eric-muhr-KrMhhUqdS-w-unsplash.jpg" />
        <link rel="preload" as="image" href="<?= $APP_URL ?>/img/planicie.jpg" />
        <link rel="preload" as="image" href="<?= $APP_URL ?>/img/island.jpg" />
        <link rel="preload" as="image" href="<?= $APP_URL ?>/img/spaceinvaders-blue.png" />
        <link rel="preload" as="image" href="<?= $APP_URL ?>/img/spaceinvaders-green.png" />
        <link rel="preload" as="image" href="<?= $APP_URL ?>/img/spaceinvaders-red.png" />
        <link rel="preload" as="image" href="<?= $APP_URL ?>/img/spaceinvaders-yellow.png" />
        <link rel="shortcut icon" href="<?= $APP_URL ?>/iconlinhaamarela.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/logo.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/pause.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/audio.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/nivel.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/markers.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/enemies.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/game.css"></style>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/styles-index.css" />

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="<?= $APP_URL ?>/js/vendor/hammer.min.js"></script>
        <script src="<?= $APP_URL ?>/js/Background.js"></script>
        <script src="<?= $APP_URL ?>/js/Counter.js"></script>
        <script src="<?= $APP_URL ?>/js/PointsCounter.js"></script>
        <script src="<?= $APP_URL ?>/js/LevelsCounter.js"></script>
        <script src="<?= $APP_URL ?>/js/LivesCounter.js"></script>
        <script src="<?= $APP_URL ?>/js/GameObject.js"></script>
        <script src="<?= $APP_URL ?>/js/Platform.js"></script>
        <script src="<?= $APP_URL ?>/js/YellowBox.js"></script>
        <script src="<?= $APP_URL ?>/js/Ball.js"></script>
        <script src="<?= $APP_URL ?>/js/SpaceInvader.js"></script>
        <script src="<?= $APP_URL ?>/js/AudioManager.js"></script>
        <script src="<?= $APP_URL ?>/js/GameBase.js"></script>
        <script src="<?= $APP_URL ?>/js/Game.js"></script>
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
    <vr>
        <audio id="game-sound" src="<?= $APP_URL ?>/mp3/residence-tatami-main-version.mp3" controls style="display: none" preload="auto"></audio>
        <div id="bg-transparent" style="width: 100%; height: 100%; position: fixed; z-index: -1;"></div>    
        
        <div class="menu">
            <div id="logo" class="unselectable game-logo"><img src="<?= $APP_URL ?>/img/logo-linhaamarela.png"/></div>
        </div>
        <div class="menu">
            <div id="pause-button" class="unselectable pause-button menu-item"><img src="<?= $APP_URL ?>/img/pause-icon-png-12.jpg"/></div>
            <div id="play-button" class="unselectable play-button menu-item"><img src="<?= $APP_URL ?>/img/png-clipart-digital-marketing-implementation-business-computer-programming-play-button-electronics-text.png"/></div>
            <div id="audio-button" class="unselectable audio-button menu-item"><img width="100%" src="<?= $APP_URL ?>/img/icons8-alto-falante-100.png"/></div>
            <img src="<?= $APP_URL ?>/img/logout.png" width="32" height="32" class="sair" />
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
                    <div><img id="qr-code" src="<?= $APP_URL ?>/img/qrcode-pix.png"/></div>
                    <div>silva.liver@gmail.com</div>
                </div>
                <div>
                    <script async="async" data-cfasync="false" src="//pl26829990.profitableratecpm.com/c36f214a2069f40ccd2d3e53c3c624b7/invoke.js"></script>
                    <div id="container-c36f214a2069f40ccd2d3e53c3c624b7"></div>
                </div>
                <div>
                    <div>Para sair clique no<br>botão abaixo</div>
                    <img src="<?= $APP_URL ?>/img/logout.png" width="100" height="100" class="sair" />
                </div>
            </div>
        </div>
        <div id="nivel" class="nivel unselectable rotate-center">Nivel</div>
        <div id="platform"></div>
        <div id="yellow-box"></div>
        <div id="red-ball"></div>
        <div id="pause" class="pause unselectable rotate-center">Pause</div>
        <audio id="toque-linha-amarela" src="<?= $APP_URL ?>/mp3/toque-linha-amarela.mp3" controls autoplay="false" style="display: none"></audio>
        <audio id="shot-audio" src="" controls autoplay="false" style="display: none"></audio>
        <audio id="creature-die" src="<?= $APP_URL ?>/mp3/creature-die.mp3" controls autoplay="false" style="display: none"></audio>
        <div class="mt-2" style="display: block; width: 100%; position: absolute; bottom: -114px; text-align: center; color: white; background-image: linear-gradient(transparent,#000000, #000000, #000000);">
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
            <a href="/"><span style="font-family: Ubuntu">n2oliver</span></a>
            <span style="font-size: 9px">Todos os direitos reservados - n2oliver -  2025</span>
            <span style="font-size: 9px">CNPJ 60.407.027/0001-25</span>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script>
            $(document).ready(()=>{
                $('.sair').click(()=>{
                    $.get('<?= $APP_URL ?>/sair.php',() => {
                        window.location.href = '<?= $APP_URL ?>';
                    });
                });
            });
        </script>
    </body>
</html>