const patterns =  {
    email: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
    username: /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/
};
class GameIntro extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);
        
        window.ball = new BallNPC({
            id: "red-ball",
            supportBarId: "yellow-box",
            width: 16,
            height: 16,
            color: "red",
            strokeColor: "#000",
            strokeStyle: "solid",
            strokeDepth: "1px",
            position: "fixed",
            positionY: "76",
            positionX: "50%",
            velocity: 1
        });

        window.ball.build(window.ball.attributes);

        const yellowBox = new YellowBoxNPC({
            id: "yellow-box",
            width: 80,
            height: 8,
            color: "yellow",
            strokeColor: "#000",
            strokeStyle: "solid",
            strokeDepth: "2px",
            position: "fixed",
            positionY: "60",
            positionX: "50%"
        });

        this.start = (e) => {
            document.onmousemove = yellowBox.mouseMove;
            const submitInscricaoButton = document.getElementById("submit-inscricao");
            const usernameInscricaoField = document.getElementById("username-inscricao");
            const emailInscricaoField = document.getElementById("email-inscricao");
            const submitButton = document.getElementById("submit-inscricao");
            const usernameField = document.getElementById("username");
            const passwordField = document.getElementById("password");
            emailInscricaoField.value = "";
            submitInscricaoButton.disabled = true;
            submitInscricaoButton.onclick = (e) => {
                if(patterns.email.test(emailInscricaoField.value)) {
                    sessionStorage.setItem('ingame', true);
                    window.location = "game.html";
                }
                submitInscricaoButton.disabled = true;
            }
            const fieldPatterns = [
                {
                    field: usernameInscricaoField, 
                    pattern: patterns.username
                },
                {
                    field: emailInscricaoField,
                    pattern: patterns.email
                }
            ]
            function validateFieldPatterns(fieldPatterns) {
                let invalid = false;
                for(let item of fieldPatterns) {
                    if(!item.pattern.test(item.field.value)) {
                        invalid = true;
                    }
                }
                return invalid;
            }
            usernameInscricaoField.onkeyup = function(e){
                submitInscricaoButton.disabled = validateFieldPatterns(fieldPatterns);
            }
            emailInscricaoField.onkeyup = function(e){
                submitInscricaoButton.disabled = validateFieldPatterns(fieldPatterns);
            }
            window.ball.init(window.ball.attributes);
            const interval = function () {
                setInterval(() => {
                    yellowBox.updatePosition()
                }, 25);
            }
            
            interval();
            
        }
    };
}
