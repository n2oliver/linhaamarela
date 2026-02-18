class LevelsCounter extends Counter  {
    level = 1;
    levelUp = new Event("levelup");
    demo = false;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        this.levelsSinceLastAd = 0; // Contador de níveis desde o último anúncio
        const styles = {
            top: "32px",
            left: "32px"
        }
        Object.assign(document.getElementById(attributes.id).parentElement.style, styles);

        this.increaseCounter = (points, previousLevel, demo) => {
            this.demo = demo;
            window.game.levelsCounter.level += 1;
            this.levelsSinceLastAd++;

            // Exibir anúncio apenas a cada 3 níveis
            if (this.levelsSinceLastAd >= 3 && typeof abrirSmartlinkUmaVez === 'function') {
                abrirSmartlinkUmaVez();
                this.levelsSinceLastAd = 0; // Resetar contador após exibir anúncio
            }

            document.dispatchEvent(this.levelUp);
        }
        this.setLevelUp();
    }
    setLevelUp = function() {
        document.addEventListener('levelup', function (e) {
            document.getElementById(window.game.levelsCounter.attributes.id).innerText = window.game.levelsCounter.level;
            window.ball.attributes.velocity = window.game.levelsCounter.level <= 11 ? window.game.levelsCounter.level : 11;
            
            $(".nivel").text("Nivel " + window.game.levelsCounter.level).show();
            setTimeout(()=> {
                $(".nivel").hide();
            }, 3000);
            
            window.spaceInvader.destroy();
            if(window.game.invaderInterval) {
                clearInterval(window.game.invaderInterval);
                window.game.invaderInterval = new SpaceInvader().init(window.game.levelsCounter.level*5)
            }
            const random = Math.floor(Math.random() * window.game.backgroundImages.length);
            window.game.background.set(window.game.backgroundImages[random]);
        }, false);
    }
}