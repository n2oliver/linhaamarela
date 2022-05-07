class LivesCounter extends Counter {
    lives = 2;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            textShadow: "3px 3px 3px #2e2e3e",
            position: "fixed",
            top: "96px"
        }
        Object.assign(document.getElementById(attributes.id).style, styles);
        
        this.decreaseCounter = (lives) => {
            window.game.livesCounter.lives -= parseInt(lives);
            document.getElementById(game.livesCounter.attributes.id).innerText = this.lives + " vidas restantes";
        }
    }
}