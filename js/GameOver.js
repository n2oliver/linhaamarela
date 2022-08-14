class GameOver extends GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        super(e, level, points, lives);

        this.start = (e) => {
            window.spaceInvaderNpc = new SpaceInvaderNPC();
            this.invaderInterval = window.spaceInvaderNpc.init();            
        }
    };
}
