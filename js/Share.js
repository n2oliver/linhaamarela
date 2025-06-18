async function takeshot() {
    let div =
        document.getElementById('your-points-box');
    return await html2canvas(div).then(
        function (canvas) {
            canvas.id = "canva";
            document
            .getElementById('output')
            .appendChild(canvas);
            return canvas;
        });
}
function saveImage(canvas) {
    
    var imageURL = canvas.toDataURL("image/jpeg");
  
    const link = document.createElement('a')
    link.href = imageURL
    link.download = 'image.jpg'
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    window.location = '/gameover.html';
}
async function share() {
    takeshot().then((canvas)=>{
        saveImage(canvas);
    });
}