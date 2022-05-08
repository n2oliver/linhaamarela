class GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    constructor(e, level, points, lives) {
        this.level = level;
        let background;

        background = new Background();
        background.set("img/planicie.jpg");
    
    };
}
