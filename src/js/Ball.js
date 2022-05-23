class Ball extends BallBase {
    constructor(attributes){
        super(attributes);
        this.build(attributes);
        this.init = function(attributes) {
            let estadoDaDirecao = {
                paraAEsquerda: false,
                paraADireita: true,
                paraCima: true,
                paraBaixo: false
            }
            return setInterval(() => {
                

                if(!window.pause) { 
                    const objectStyle = document.getElementById(attributes.id).style;
                    const limiteHorizontalInferior = window.innerHeight - 60;
                    const supportBarLeft = document.getElementById(attributes.supportBarId).offsetLeft;
                    const supportBarRight = supportBarLeft + parseInt(document.getElementById(attributes.supportBarId).style.width) + 2;
                    const top = parseInt(document.getElementById(attributes.id).offsetTop);
                    const left = parseInt(document.getElementById(attributes.id).offsetLeft);
                    const right = left + attributes.width;
                    const height = parseInt(attributes.height) + 2;

                    if(left <= 0) {
                        estadoDaDirecao.paraAEsquerda = false;
                        estadoDaDirecao.paraADireita = true;
                    }
                    if(!estadoDaDirecao.paraADireita){
                        estadoDaDirecao.paraAEsquerda = true;
                        estadoDaDirecao.paraADireita = false;
                    }

                    if(top <= 0) {
                        estadoDaDirecao.paraCima = false;
                        estadoDaDirecao.paraBaixo = true;
                    }
                    if(!estadoDaDirecao.paraBaixo){
                        estadoDaDirecao.paraCima = true;
                        estadoDaDirecao.paraBaixo = false;
                    }

                    if(left >= window.innerWidth - 32) {
                        estadoDaDirecao.paraAEsquerda = true;
                        estadoDaDirecao.paraADireita = false;
                    }
                    if(!estadoDaDirecao.paraAEsquerda){
                        estadoDaDirecao.paraAEsquerda = false;
                        estadoDaDirecao.paraADireita = true;
                    }

                    if(top + height >= limiteHorizontalInferior && top <= limiteHorizontalInferior && right >= supportBarLeft - 32 && left <= supportBarRight) {
                        estadoDaDirecao.paraCima = true;
                        estadoDaDirecao.paraBaixo = false;
                        const audio = document.getElementById("toque-linha-amarela");
                        if(audio.readyState) {
                            audio.play();
                        }
                    
                    } 
                    if(!estadoDaDirecao.paraCima){
                        estadoDaDirecao.paraCima = false;
                        estadoDaDirecao.paraBaixo = true;
                    }

                    let direction = 3;
                    if(estadoDaDirecao.paraAEsquerda) {
                        direction = -3;
                    }  
                    objectStyle.left = (left + direction * attributes.velocity) + "px";
                    
                    if(estadoDaDirecao.paraCima) {
                        objectStyle.top = (top - 2 * attributes.velocity) + "px";
                    } else if(estadoDaDirecao.paraBaixo) {
                        objectStyle.top = (top + 2 * attributes.velocity) + "px";
                    }
                }
            }, 50);
        }
    }
}