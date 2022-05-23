class Background {
    constructor () {
        this.set = (image) => {
            const objectStyle = document.body.style;
            const style = {
                background: "url(" + image + ") no-repeat center center fixed",
                'background-size': "cover",
                position: "relative",
                width: "100%",
                height: "100%",
            }
            Object.assign(objectStyle, style);
        }
    }
}