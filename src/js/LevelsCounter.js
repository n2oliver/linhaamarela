

class LevelsCounter extends Counter  {
    level = 1;
    levelUp = new Event("levelup");
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            textAlign: "left",
            textShadow: "3px 3px 3px #2e2e3e",
            position: "fixed",
            top: "32px",
            left: "32px"
        }
        Object.assign(document.getElementById(attributes.id).style, styles);

        this.increaseCounter = (points, previousLevel) => {
            window.game.levelsCounter.level = parseInt((points + 250) / 250);

            if(previousLevel < parseInt((points + 250) / 250)) {
                document.dispatchEvent(this.levelUp);
            }
        }
        this.setLevelUp();
    }
    setLevelUp = function() {
        document.addEventListener('levelup', function (e) {
            document.getElementById(window.game.levelsCounter.attributes.id).innerText = "Nivel: " + window.game.levelsCounter.level;
            window.ball.attributes.velocity = window.game.levelsCounter.level;
            console.log("Chamou!");
        }, false);
    }
}