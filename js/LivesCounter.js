class LivesCounter extends Counter {
    lives = 2;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            top: "96px",
            left: "32px"
        }
        Object.assign(document.getElementById(attributes.id).parentElement.style, styles);
        
        this.decreaseCounter = (lives) => {
            window.game.livesCounter.lives -= parseInt(lives);
            document.getElementById(game.livesCounter.attributes.id).innerText = this.lives;
        }
    }
}