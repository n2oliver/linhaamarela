class Background {
    constructor () {
        this.set = (image) => {
            const objectStyle = document.body.style;
            objectStyle.background = "url(" + image + ") no-repeat center center fixed";
            objectStyle.backgroundSize = "cover";
        }
    }
}