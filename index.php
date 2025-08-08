<?php 
include('../../load-env.php');
include('../../database/connectdb.php');
include('./repositories/LoginRepository.php');
include('./repositories/UsuarioRepository.php');
$APP_URL = '/jogos/linhaamarela';
$_SESSION['email_validado'] = null;
$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : '';
if(isset($usuario_id)) {
    $usuarioRepository = new UsuarioRepository($pdo);
    $usuario = $usuarioRepository->obterUsuarioPorId($usuario_id);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include('../../g-tags.php'); ?>
    <title>Linha Amarela | n2oliver</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- Dependências de terceiros -->
    <!-- CSS -->
    <link rel="shortcut icon" href="<?= $APP_URL ?>/iconlinhaamarela.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/styles-index.css" />
    <link rel="stylesheet" href="/sobre-mim.css" />

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <script src="<?= $APP_URL ?>/js/vendor/require.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Dependências do projeto -->
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $APP_URL ?>/css/logo.css"/>
    <link rel="stylesheet" href="<?= $APP_URL ?>/css/landing.css"/>
    <link rel="stylesheet" href="<?= $APP_URL ?>/css/audio.css"/>
    <link rel="stylesheet" href="<?= $APP_URL ?>/css/pause.css"/>
    <link rel="stylesheet" href="<?= $APP_URL ?>/css/spinner.css" />

    <script src="<?= $APP_URL ?>/js/AudioManager.js"></script>
    <script src="<?= $APP_URL ?>/js/Login.js"></script>
    <style>
        iframe {
            width: 100%;
            max-width: 468px;
        }
        .error {
            background: linear-gradient(135deg,#ffa573,#f57754);
        }
        .warning {
            background: linear-gradient(135deg,#ffff73,#ffa554);
        }
        .success {
            background: linear-gradient(135deg,#54a554,#77f554);
        }
        .jumbotron {
            position: relative;
            z-index: 0;
            padding: 50px;
            color: white;
            font-size: 2rem;
            overflow: hidden;
        }

        .jumbotron::before {
            content: "";
            position: absolute;
            inset: 0;
            background: inherit; /* herda a imagem de fundo */
            z-index: -1;
            animation: enemymoves 15s linear infinite;
            filter: brightness(1) hue-rotate(0deg);
        }

        @keyframes enemymoves {
            0% {
                background-position-x: 0vw;
                filter: brightness(1) hue-rotate(0deg);
            }
            15%, 25% {
                filter: brightness(0.2) hue-rotate(72deg);
            }
            35%, 50% {
                filter: brightness(1.2) hue-rotate(144deg);
            }
            65%, 75% {
                filter: brightness(0.5) hue-rotate(216deg);
            }
            85%, 100% {
                filter: brightness(1) hue-rotate(360deg);
            }
            100% {
                background-position-x: 100vw;
            }
        }

    </style>
    <script type='text/javascript' src='//pl27371375.profitableratecpm.com/af/e7/3c/afe73c790e73cadb95ef255203cc5f61.js'></script>
    <script type="text/javascript" data-cfasync="false" src="/popads-monetization.js"></script>
</head>
<body style="background: url(<?= $APP_URL ?>/img/fundo.png)">
    <div class="spinner d-none"></div>
    <audio id="main-menu-sound" src="<?= $APP_URL ?>/mp3/try-infraction-main-version.mp3" controls style="display: none" preload="auto"></audio>
    <audio id="game-sound" src="<?= $APP_URL ?>/mp3/residence-tatami-main-version.mp3" controls style="display: none" preload="auto"></audio>

    <div class="container" style="z-index: 10; background-color: transparent !important; margin: 0 auto">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a href="<?= $APP_URL ?>" style="text-decoration: none; color: yellow !important; -webkit-text-stroke: 1px black">Linha Amarela</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Sobre o Desenvolvedor</a>
                    </li>
                    
                </ul>
                <div class="menu d-flex align-content-center justify-content-center">
                    <div id="audio-button" class="unselectable audio-button menu-item mx-2"><img width="32" height="32" src="<?= $APP_URL ?>/img/icons8-alto-falante-100.png"/></div>
                    <?php
                    if(!isset($usuario['email'])) {
                    ?>
                        <small class="row text-left">
                        <div id="camada-email" class="col-md-6 px-2">
                            <strong>E-mail:</strong>
                            <input id="email" type="text" class="form-control" placeholder="E-mail" />
                            <small id="nao-tenho-conta" class="recovery-link m-1 text-nowrap">Não tenho uma conta</small>
                        </div>
                        <div id="camada-nome" class="col-md-6 px-2 d-none">
                            <strong>Nome:</strong>
                            <input id="nome" type="text" class="form-control" placeholder="Nome" />
                        </div>    
                        <div id="camada-senha" class="col-md-6 px-2">
                            <strong>Senha:</strong>
                            <div class="row align-items-start">
                                <div class="col-6 pl-0 py-0">
                                    <input id="senha" type="password" class="form-control" placeholder="Senha" />
                                    <small id="esqueci-senha" class="recovery-link m-1 text-nowrap">Esqueci minha senha</small>
                                </div>
                                <div class="col-6 px-0 py-0">
                                    <button class="btn btn-primary" id="login">Login</button>
                                </div>
                            </div>
                        </div>
                        <div id="cadastrar-senha" class="col-md-6 px-2 d-none">
                            <strong>Criar nova senha:</strong>
                            <div class="row align-items-start">
                                <div class="col-6 pl-0 py-0">
                                    <input id="cadastro-senha" type="password" class="form-control" placeholder="Senha" />
                                    <small id="sair-cadastro" class="recovery-link m-1 text-nowrap text-danger">Cancelar</small>
                                </div>
                                <div class="col-6 px-0 py-0">
                                    <button class="btn btn-success" id="cadastrar">Cadastrar</button>
                                </div>
                            </div>
                        </div>
                        <div id="codigo-email" class="col-md-6 px-2 d-none">
                            <strong>Código:</strong>
                            <div class="row align-items-start">
                                <div class="col-6 px-0 py-0">
                                    <input id="codigo-enviado" type="text" class="form-control" placeholder="Cole aqui" />
                                </div>
                                <div class="col-6 pr-0 py-0">
                                    <button id="verificar" class="btn btn-success text-nowrap">Verificar</button>
                                </div>
                            </div>
                            <small id="nao-recebi" class="recovery-link m-1 text-nowrap d-none">Não recebi o código</small>
                            <small id="cancelar" class="recovery-link m-1 text-nowrap d-none text-danger">Cancelar</small>
                        </div>
                        </small>  
                    </div>
                    <?php } else { ?>
                        <div class="nav-item align-content-center">
                            <small><strong>Bem vindo de volta, <?= $usuario['nome'] ?>!</strong></small> <br>
                            <small><?= $usuario['email'] ?></small> <br>
                            <img src="<?= $APP_URL ?>/img/logout.png" width="32" height="32" id="sair" />
                        </div>
                    <?php } ?>
            </div>
        </nav>
        <div class="jumbotron text-center">
            <h1 class="display-4" style="color: white; word-wrap: normal;">Eles iniciaram, a invasão começou!</h1>
            <p class="lead" style="color: white">Ajude-nos a defender Long Trek de uma catástrofe alienígena!</p>
            <button id="partida" class="btn btn-danger btn-lg">Partida rápida</button>
            <br>ou<br>
            <button id="jogar" class="btn btn-warning btn-lg">Competição</button>
        </div>

        <div class="text-light mx-auto mt-3 col-md-8 text-center">
            Anúncios
        </div>
        <div class="container m-auto col-md-8 text-light">
            <script async="async" data-cfasync="false" src="//pl27079464.profitableratecpm.com/297c1c3c46604eb55408b6261c6dd5b3/invoke.js"></script>
            <div id="container-297c1c3c46604eb55408b6261c6dd5b3"></div>
        </div>
        <br>
        <?php include("../../footer.php"); ?>
    </div>
    <script>
        const audioManager = new AudioManager();
        const audioButton = document.getElementById("audio-button");
        const mainMenuSound = document.getElementById("main-menu-sound");
        const login = new Login();
        const appUrl = '<?= $APP_URL ?>';
        audioButton.onclick = () => {
            if(localStorage.mute == 'on') {
                localStorage.setItem('mute', 'off');
                audioButton.querySelector("img").src = `${appUrl}/img/icons8-alto-falante-100.png`;
                mainMenuSound.play();
                return;
            }
            localStorage.setItem('mute', 'on');
            audioButton.querySelector("img").src = `${appUrl}/img/icons8-mute-64.png`;
            mainMenuSound.pause();
        }
        $(document).ready(()=>{
            $('#login').click(login.login);
            
            $('#sair').click(()=>{
                $.get(`${appUrl}/sair.php`,() => {
                    window.location.href = appUrl;
                });
            });

            $('#nao-tenho-conta').click(login.naoTenhoConta);

            $('#sair-cadastro').click(login.sairCadastro);

            $('#esqueci-senha').click(login.passwordRecovery);

            $('#jogar').click(()=>{
                if(!($('.navbar-toggler').attr('aria-expanded') == 'true') && !Boolean('<?= $usuario_id ?>')) {
                    document.querySelector('.navbar-toggler').click();
                } else if(Boolean('<?= isset($usuario_id) ? $usuario_id : 'false' ?>')) {
                    window.location.href = `${appUrl}/game.php`;
                } else {
                    Toastify({
                        text: 'Você precisa entrar primeiro!',
                        duration: 3000,
                        style: {
                        background: "linear-gradient(to right, #b09b00, #ff0000)",
                        },
                    }).showToast();
                }
            });
            $('#partida').click(()=>{
                window.location.href = `${appUrl}/fast-game.php`;
            })
        })
    </script>
</body>
</html>