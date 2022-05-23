

class LevelsCounter extends Counter  {
    level = 1;
    levelUp = new Event("levelup");
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            top: "32px",
            left: "32px"
        }
        Object.assign(document.getElementById(attributes.id).parentElement.style, styles);

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
            document.getElementById(window.game.levelsCounter.attributes.id).innerText = window.game.levelsCounter.level;
            window.ball.attributes.velocity = window.game.levelsCounter.level;
            
            $(".nivel").text("Nivel " + window.game.levelsCounter.level).show();
            setTimeout(()=> {
                $(".nivel").hide();
            }, 3000);
            
            window.spaceInvader.destroy();
            clearInterval(window.game.invaderInterval);
            window.game.invaderInterval = new SpaceInvader().init(window.game.levelsCounter.level*2)
            console.log("Chamou!");
        }, false);
    }
}