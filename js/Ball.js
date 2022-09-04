class Ball extends GameObject {
    constructor(attributes){
        super(attributes);
        this.build = function(attributes) {
            const styles = {
                borderRadius: attributes.width + "px",
                transform: "translateX(16px)",
                position: attributes.position,
            }
            Object.assign(document.getElementById(attributes.id).style, styles);
        }
        this.init = function(attributes) {
            let estadoDaDirecao = {
                paraAEsquerda: false,
                paraADireita: true,
                paraCima: true,
                paraBaixo: false
            }
            return setInterval(() => {
                if(!window.pause) { 
                    const element = document.getElementById(attributes.id);
                    const supportBar = document.getElementById(attributes.supportBarId);
                    const objectStyle = element.style;
                    const limiteHorizontalInferior = window.innerHeight - 60;
                    const supportBarRight = supportBar.offsetLeft + parseInt(supportBar.style.width) + 2;
                    const top = parseInt(element.offsetTop);
                    const left = parseInt(element.offsetLeft);
                    const right = left + attributes.width;
                    const height = parseInt(attributes.height) + 2;

                    if(left <= 0) estadoDaDirecao = Ball.moverParaADireita(estadoDaDirecao);

                    if(top <= 0) estadoDaDirecao = Ball.moverParaBaixo(estadoDaDirecao);

                    if(left >= window.innerWidth - 32) estadoDaDirecao = Ball.moverParaAEsquerda(estadoDaDirecao);

                    if(!estadoDaDirecao.paraADireita) estadoDaDirecao = Ball.moverParaAEsquerda(estadoDaDirecao);
 
                    if(!estadoDaDirecao.paraAEsquerda) estadoDaDirecao = Ball.moverParaADireita(estadoDaDirecao);

                    if(!estadoDaDirecao.paraCima) estadoDaDirecao = Ball.moverParaBaixo(estadoDaDirecao);

                    if(!estadoDaDirecao.paraBaixo) estadoDaDirecao = Ball.moverParaCima(estadoDaDirecao);

                    const pisoDaBola = top + height;
                    const passouDoLimiteInferior = pisoDaBola >= limiteHorizontalInferior;
                    const topoDaBolaAcimaDolimiteInferior = top <= limiteHorizontalInferior;
                    const colisaoDaBolaComALinhaAmarela = right >= supportBar.offsetLeft - 32 && left <= supportBarRight;
                    const ocorreuColisao = passouDoLimiteInferior && topoDaBolaAcimaDolimiteInferior && colisaoDaBolaComALinhaAmarela;

                    if(ocorreuColisao) {
                        estadoDaDirecao = Ball.moverParaCima(estadoDaDirecao);
                        const audio = document.getElementById("toque-linha-amarela");
                        if(audio && audio.readyState) {
                            audio.play();
                        }
                    }

                    let direction;
                    if(estadoDaDirecao.paraAEsquerda) direction = -3
                    else direction = 3;

                    objectStyle.left = (left + direction * attributes.velocity) + "px";

                    if(estadoDaDirecao.paraCima) {
                        objectStyle.top = (top - 2 * attributes.velocity) + "px";
                    } else if(estadoDaDirecao.paraBaixo) {
                        objectStyle.top = (top + 2 * attributes.velocity) + "px";
                    }
                }
            }, 50);
        }
        this.build(attributes);
    }
    static moverParaADireita(estadoDaDirecao) {
        estadoDaDirecao.paraAEsquerda = false;
        estadoDaDirecao.paraADireita = true;
        return estadoDaDirecao;
    }
    static moverParaAEsquerda(estadoDaDirecao) {
        estadoDaDirecao.paraAEsquerda = true;
        estadoDaDirecao.paraADireita = false;
        return estadoDaDirecao;
    }
    static moverParaBaixo(estadoDaDirecao) {
        estadoDaDirecao.paraCima = false;
        estadoDaDirecao.paraBaixo = true;
        return estadoDaDirecao;
    }
    static moverParaCima(estadoDaDirecao) {
        estadoDaDirecao.paraCima = true;
        estadoDaDirecao.paraBaixo = false;
        return estadoDaDirecao;
    }
}