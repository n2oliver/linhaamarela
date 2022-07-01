class GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    background;
    backgroundImages = [
        "img/planicie.jpg",
        "img/eric-muhr-KrMhhUqdS-w-unsplash.jpg",
        "img/island.jpg"
    ];
    constructor(e, level, points, lives) {
        this.level = level;
        this.background = new Background();
        const random = Math.floor(Math.random() * this.backgroundImages.length);
        this.background.set(this.backgroundImages[random]);
    };
}
