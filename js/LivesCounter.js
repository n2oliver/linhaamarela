class LivesCounter extends Counter {
    lives = 3;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            textAlign: "right",
            textShadow: "3px 3px 3px #2e2e3e"
        }
        Object.assign(document.getElementById(attributes.id).style, styles);
        
        this.decreaseCounter = (lives) => {
            this.lives -= parseInt(lives);
            document.getElementById(game.livesCounter.attributes.id).innerText = this.lives + " vidas restantes";
        }
    }
}