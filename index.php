<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Linha Amarela</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- Dependências de terceiros -->
    <!-- CSS -->
    <link rel="shortcut icon" href="/jogos/linhaamarela/iconlinhaamarela.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/styles-index.css" />

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <script src="/jogos/linhaamarela/js/vendor/require.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Dependências do projeto -->
    <!-- CSS -->
        <link rel="stylesheet" href="/jogos/linhaamarela/css/logo.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/landing.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/audio.css"/>
        <link rel="stylesheet" href="/jogos/linhaamarela/css/pause.css"/>
        <script src="/jogos/linhaamarela/js/AudioManager.js"></script>
</head>
<body style="background: url(/jogos/linhaamarela/img/upscaled-monsters.png)">
    <audio id="main-menu-sound" src="/jogos/linhaamarela/mp3/try-infraction-main-version.mp3" controls style="display: none" preload="auto"></audio>
    <audio id="game-sound" src="/jogos/linhaamarela/mp3/residence-tatami-main-version.mp3" controls style="display: none" preload="auto"></audio>

    <div class="container" style="z-index: 10; background-color: transparent !important; margin: 0 auto">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/jogos/linhaamarela">Linha Amarela</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/jogos/linhaamarela">Página inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/jogos/linhaamarela/game.php">Jogar</a>
                    </li>
                </ul>
                <div class="menu">
                    <div id="audio-button" class="unselectable audio-button menu-item"><img width="100%" src="/jogos/linhaamarela/img/icons8-alto-falante-100.png"/></div>
                </div>
            </div>
        </nav>
        <div class="jumbotron text-center">
            <h1 class="display-4" style="color: white">Eles iniciaram, a invasão começou!</h1>
            <p class="lead" style="color: white">Ajude-nos a defender Long Trek de uma catástrofe alienígena!</p>
            <a href="/jogos/linhaamarela/game.php" class="btn btn-primary btn-lg">Jogar</a><br><br>

        </div>
        <?php include("../../noads-footer.php"); ?>
    </div>
    <script>
        document.getElementById("audio-button").onclick = () => {
            if(localStorage.mute == 'on') {
                localStorage.setItem('mute', 'off');
                document.getElementById("audio-button").querySelector("img").src = "/jogos/linhaamarela/img/icons8-alto-falante-100.png";
                return;
            }
            localStorage.setItem('mute', 'on');
            document.getElementById("audio-button").querySelector("img").src = "/jogos/linhaamarela/img/icons8-mute-64.png";
        }
    </script>
</body>
</html>