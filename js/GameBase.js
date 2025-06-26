class GameBase {
    pointsCounter;
    livesCounter;
    levelsCounter;
    level;
    background;
    backgroundImages = [
        "/jogos/linhaamarela/img/fundo.png",
    ];
    constructor(e, level, totalDeMonstros, top) {
        this.level = level;
        this.background = new Background();
        const random = Math.floor(Math.random() * this.backgroundImages.length);
        this.background.set(this.backgroundImages[random]);
        this.top = top;
        this.totalDeMonstros = totalDeMonstros;
        this.level = level;
    };
}
