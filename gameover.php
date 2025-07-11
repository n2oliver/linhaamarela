<?php
include('./load-env.php');
require('./database/connectdb.php');
require('./verifica-login.php');
$APP_URL = "/jogos/linhaamarela";
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php include('../../g-tags.php'); ?>
        <title>Linha Amarela | n2oliver</title>
        <meta charset="utf-8" />
        <meta name="viewport" 
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" href="<?= $APP_URL ?>/iconlinhaamarela.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/markers.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/info.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/logo.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/game-over.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/table.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/enemies.css"/>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/box.css"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="<?= $APP_URL ?>/js/Background.js"></script>
        <script src="<?= $APP_URL ?>/js/Counter.js"></script>
        <script src="<?= $APP_URL ?>/js/PointsCounter.js"></script>
        <script src="<?= $APP_URL ?>/js/GameObject.js"></script>
        <script src="<?= $APP_URL ?>/js/SpaceInvaderNPC.js"></script>
        <script src="<?= $APP_URL ?>/js/GameBase.js"></script>
        <script src="<?= $APP_URL ?>/js/GameOver.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js"></script>
        <script src="<?= $APP_URL ?>/js/Share.js"></script>
        <link rel="stylesheet" href="<?= $APP_URL ?>/css/spinner.css" />
        <script>
            window.game;
            window.onload = (e) => {
                if(sessionStorage.pontuacao) {
                    $("#game-over").show();
                    $("#your-points-box").show();
                }
                level = 1;
                game = new GameOver(e, level);
                game.start(e);
            }
        </script>
    </head>
    <body>
        <div class="spinner d-none"></div>
        <div id="game-over" class="row" style="display: none">
            <div class="col-md-2"></div>
            <div class="col-md-8 presentation text-warning box-title game-over-ending mt-3">Ah, não!</div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8 box-body game-over-ending text-danger mb-3"><strong>O extraterrestres invadiram a Terra!</strong></div>
            <div class="col-md-2"></div>
        </div>
        <div id="your-points-box" class="row" style="display: none">
            <div class="col-md-2"></div>
            <div id="div-ranking" class="col-md-8 presentation text-white box-title title-ranking mt-3">Sua pontuação<img width="100" src="<?= $APP_URL ?>/img/logo-linhaamarela.png" style="float: right; position: relative; top: 6px";/></div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div id="div-ranking" class="col-md-8 box-body">
                <table id="your-points" class="table table-center">
                    <thead>
                        <tr>
                            <th>Posição</th><th>Usuário</th><th>Pontuação</th>
                        </tr>
                    </thead>
                    <tbody id="pontuacao">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row align-content-center justify-content-center mt-5">

            <div class="col-md-2"></div>
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
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div id="div-ranking" class="col-md-8 presentation text-white box-title title-ranking mt-3">Recordes</div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div id="div-ranking" class="col-md-8 box-body">
                <table id="all-points" class="table">
                    <thead>
                        <tr>
                            <th>Posição</th><th>Usuário</th><th>Pontuação</th>
                        </tr>
                    </thead>
                    <tbody id="lista">
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <nav aria-label="Page navigation example" class="col-md-12 d-inline-flex p-2 justify-content-center">
                    <ul id="pagination" class="pagination">
                    </ul>
                </nav>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="logo">
            <div id="logo" style="margin: 0 auto; margin-bottom: 40px; text-align: center; position: relative; left: 0; right: 0;" class="d-inline-flex align-items-center justify-content-around presentation text-warning w-100">
                <div>
                    <a href="<?= $APP_URL ?>/game.php"><button class="button" style="background: limegreen">Novo jogo</button></a>
                    <a href="<?= $APP_URL ?>/index.php"><button class="button" style="background: blue">Voltar</button></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div id="invaders" class="col-md-8"></div>
            <div class="col-md-2"></div>
        </div>
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2" id="output"></div>
        </div>
        <script>const usuarioId = <?= $_SESSION['usuario_id'] ?>;</script>
        <script src="<?= $APP_URL ?>/js/pontuacao.js"></script>
    </body>
</html>