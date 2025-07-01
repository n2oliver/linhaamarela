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
        
        this.decreaseCounter = () => {
            window.game.livesCounter.lives -= 1;
            let lifeDisplay = '<div class="heart"></div>';
            for(let i=0; i < this.lives; i++) {
                lifeDisplay += '<div class="heart"></div>';
            }
            document.getElementById(game.livesCounter.attributes.id).innerHTML = lifeDisplay;
        }
        this.increaseCounter = () => {
            window.game.livesCounter.lives += 1;
            let lifeDisplay = '<div class="heart"></div>';
            for(let i=0; i < this.lives; i++) {
                lifeDisplay += '<div class="heart"></div>';
            }
            document.getElementById(game.livesCounter.attributes.id).innerHTML = lifeDisplay;
        }
    }
}