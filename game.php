<?php 
$APP_URL = '/jogos/linhaamarela';
include('./load-env.php');
require('./database/connectdb.php');
require('./verifica-login.php');
require('./repositories/PontoRepository.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php include('/g-tags.php'); ?>

        <title>Linha Amarela</title>
        <meta charset="utf-8" />
        <meta name="viewport" 
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="preload" as="style" href="<?= $APP_URL ?>/css/game.css" />
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
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/game-over.css"></style>
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
            .d-none {
                display: none !important;
            }
            #game-over {
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                margin: 0 auto;
                position: fixed;
                left: 0;
                right: 0;
            }
            #game-over h1 {
                font-size: 64px;
                color: yellow;
                -webkit-text-stroke: gray 2px;
            }
            #game-over .box-title {
                font-size: 42px
            }
        </style>
    </head>
    <body>
        <div class="spinner d-none"></div>
        <audio id="game-sound" src="<?= $APP_URL ?>/mp3/residence-tatami-main-version.mp3" controls style="display: none" preload="auto"></audio>
        <div id="bg-transparent" style="width: 100%; height: 100%; position: fixed; z-index: -1;"></div>    
        
        <div class="menu">
            <div id="pause-button" class="unselectable pause-button menu-item"><img src="<?= $APP_URL ?>/img/pause-icon-png-12.jpg"/></div>
            <div id="play-button" class="unselectable play-button menu-item"><img src="<?= $APP_URL ?>/img/png-clipart-digital-marketing-implementation-business-computer-programming-play-button-electronics-text.png"/></div>
            <div id="audio-button" class="unselectable audio-button menu-item"><img width="100%" src="<?= $APP_URL ?>/img/icons8-alto-falante-100.png"/></div>
            <div id="logo" class="unselectable game-logo"><img src="<?= $APP_URL ?>/img/logo-linhaamarela.png"/></div>      
            <img src="<?= $APP_URL ?>/img/logout.png" width="32" height="32" class="sair" />
            <?php if(isset($_SESSION['usuario_id']) && !isset($_SESSION['partida_rapida'])) { ?>
                <script>
                    window.usuarioId = <?= isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 'null' ?>;
                    window.partidaRapida = <?= isset($_SESSION['partida_rapida']) ? $_SESSION['partida_rapida'] : 'null' ?>;
                </script>
                <hr>
                <div>
                    <div class="presentation-container unselectable">Pontos: <span id="points-counter">0</span></div>
                    
                    <h1>Ranking</h1>
                    <div>
                        <table id="all-points" class="table">
                            <thead>
                                <tr>
                                    <th>Posição</th><th>Usuário</th><th>Pontuação</th>
                                </tr>
                            </thead>
                            <tbody id="ranking">
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <hr>
                <div>
                    <div class="presentation-container unselectable">Pontos: <span id="points-counter">0</span></div>
                </div>
            <?php } ?> 
        </div>
        <div class="menu-item markers">
            <div class="presentation-container unselectable">Nivel: <span id="levels-counter">1</span></div>
            <div class="presentation-container unselectable"><span id="vidas"><div class="heart"></div><div class="heart"></div><div class="heart"></div></span></div>
        </div>
        <div id="qr-code" style="display: none; color: white; z-index: 9999;" class="qr-code rotate-center">
            <div style="display: flex; justify-content: space-around; align-content: center;">
                <div>
                    <div>Aceitamos doações:</div>
                    <div>Chave PIX:</div>
                    <div><img id="qr-code" src="<?= $APP_URL ?>/img/qrcode-pix.png"/></div>
                    <div>silva.liver@gmail.com</div>
                </div>
                <div>
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

        <div id="game-over" class="d-none">
            <h1>Game Over</h1>
            <div class="box-title game-over-ending mt-3">Ah, não!</div>
            <div class="box-body game-over-ending text-danger mb-3"><strong>O extraterrestres invadiram a Terra!</strong></div>
            <div><button id="restart" style="background: darkorange; margin-top: 20px;">Reiniciar</button></div>
            <div><a href='<?= $APP_URL ?>/sair.php'><button class="sair" style="margin-top: 20px;">Sair</button></a></div>
        </div>

        <div id="platform"></div>
        <div id="yellow-box"></div>
        <div id="red-ball"></div>
        <div id="pause" class="pause unselectable rotate-center">Pause</div>
        <audio id="toque-linha-amarela" src="<?= $APP_URL ?>/mp3/toque-linha-amarela.mp3" controls autoplay="false" style="display: none"></audio>
        <audio id="shot-audio" src="" controls autoplay="false" style="display: none"></audio>
        <audio id="creature-die" src="<?= $APP_URL ?>/mp3/creature-die.mp3" controls autoplay="false" style="display: none"></audio>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script>
            $(document).ready(()=>{
                $('.sair').click(()=>{
                    window.location.href = '<?= $APP_URL ?>/sair.php';
                });
                if(typeof usuarioId !== 'undefined') obterRanking(usuarioId);
            });
            function obterRanking(idUsuario) {
                $('.spinner').removeClass('d-none');
                $.ajax({
                    url: './obter-ranking.php',
                    method: 'POST',
                    type: 'json/application',
                    data: { id_usuario: idUsuario },
                    success: (data) => {
                        $('.spinner').addClass('d-none');
                        const pontuacoes = data;
                        const ranking = $('#ranking');
                        ranking.html(pontuacoes);
                    },
                    error: (error) => {
                        $('.spinner').addClass('d-none');
                        console.log(error.responseText);
                    }
                });
            }
        </script>

        <script src="<?= $APP_URL ?>/js/pontuacao.js"></script>
    </body>
</html>