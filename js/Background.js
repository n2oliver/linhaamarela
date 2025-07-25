class Background {
    constructor () {
        this.set = (image) => {
            const objectStyle = document.body.style;
            const style = {
                background: "url(" + image + ") no-repeat center center fixed",
                'background-size': "cover",
                position: "relative",
                width: "100vw",
                height: "100vh",
                margin: "0 auto",
                "z-index": "-1",
            }
            Object.assign(objectStyle, style);
        }
    }
}