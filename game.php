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
        
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-687386749"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-687386749');
        </script>

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
        <script>
            sessionStorage.userId = <?= $_SESSION['usuario_id'] ?>;
        </script> 
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
            <hr>
            <div>
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
        </div>
        <div class="menu-item markers">
            <div class="presentation-container unselectable">Nivel: <span id="levels-counter">1</span></div>
            <div class="presentation-container unselectable">Pontos: <span id="points-counter">0</span></div>
            <div class="presentation-container unselectable">Vidas restantes: <span id="vidas">2</span></div>
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
            const usuarioId = <?= $_SESSION['usuario_id'] ?>;
            $(document).ready(()=>{
                $('.sair').click(()=>{
                    $.get('<?= $APP_URL ?>/sair.php',() => {
                        window.location.href = '<?= $APP_URL ?>';
                    });
                });
                obterRanking(usuarioId);
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