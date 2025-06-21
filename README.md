# 🎮 Linha Amarela

**Linha Amarela** é um jogo de navegador no estilo arcade onde o jogador controla uma "linha amarela" para rebater uma bola e destruir invasores espaciais. O jogo é totalmente desenvolvido em **JavaScript Vanilla**, com backend em **PHP**, e traz um estilo retrô moderno com progressão de níveis, sons, efeitos e colisões.

![screenshot](./img/logo-linhaamarela.png)

## 🚀 Demonstração

👉 [Jogue agora](https://oliver.liveblog365.com/jogos/linhaamarela/)  
🕹️ Requer navegador moderno com JavaScript habilitado.

---

## 📦 Funcionalidades

- ✅ Detecção de colisões (borda, barra, inimigos)
- ✅ Movimento responsivo com mouse e toque (Hammer.js)
- ✅ Progressão de níveis com aumento de dificuldade
- ✅ Sistema de vidas e pontuação
- ✅ Efeitos sonoros e música de fundo
- ✅ Pausar e retomar o jogo
- ✅ Inimigos animados e caixa de ajuda com power-up

---

## 🛠️ Tecnologias

- **Frontend:** HTML5, CSS3, JavaScript (ES6)
- **Backend:** PHP (para login/session/logout)
- **Bibliotecas:** [Hammer.js](https://hammerjs.github.io/)
- **Design:** Estilo retrô com sprites personalizados

---

## 📁 Estrutura

linhaamarela/

├── css/

│ └── game.css, logo.css, pause.css, etc.

├── img/

│ └── assets do jogo (invasores, fundo, ícones)

├── js/

│ └── Game.js, GameObject.js, Ball.js, etc.

├── mp3/

│ └── Áudios do jogo

├── database/

│ └── connectdb.php

├── verifica-login.php

├── sair.php

├── game.php

├── gameover.html

└── README.md

## 🧑‍💻 Instalação local

1. Clone o repositório:
   ```bash
   git clone https://github.com/seunome/linhaamarela.git

2. Configure seu ambiente local com PHP (Apache, XAMPP ou similar).

3. Certifique-se de que a pasta linhaamarela/ está acessível via navegador, ex.:
   ```bash
   http://localhost/linhaamarela/game.php

4. Para ativar o controle de login, edite os arquivos verifica-login.php e connectdb.php com seus dados.

🤝 Contribuição

Contribuições são bem-vindas! Abra uma issue ou envie um pull request com melhorias, novos níveis ou sugestões.
📬 Contato

Desenvolvido por Óliver Silva Castilho
📧 silva.liver@gmail.com
📱 (21) 98669-5629
📝 Licença

Este projeto está licenciado sob a MIT License.
💛 Curtiu?

Se esse jogo te divertiu, considere fazer uma doação via PIX para ajudar no desenvolvimento de novos projetos.
Chave PIX: silva.liver@gmail.com
