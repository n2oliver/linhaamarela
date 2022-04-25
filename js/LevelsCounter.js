class LevelsCounter extends Counter  {
    level = 1;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            textAlign: "right",
            textShadow: "3px 3px 3px #2e2e3e",
            position: "fixed",
            bottom: "136px",
            right: "12px"
        }
        Object.assign(document.getElementById(attributes.id).style, styles);

        this.increaseCounter = (points) => {
            window.game.levelsCounter.level = parseInt((points + 250) / 250);
            document.getElementById(this.attributes.id).innerText = "Nivel: " + window.game.levelsCounter.level;
            window.ball.attributes.velocity = window.game.levelsCounter.level;
        }
    }
}