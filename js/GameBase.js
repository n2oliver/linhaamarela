class GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    background;
    backgroundImages = [
        "img/upscaled-monsters.png",
    ];
    constructor(e, level, points, lives) {
        this.level = level;
        this.background = new Background();
        const random = Math.floor(Math.random() * this.backgroundImages.length);
        this.background.set(this.backgroundImages[random]);
    };
}
