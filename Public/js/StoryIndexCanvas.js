/**
 * Created by desire on 16/6/9.
 */
// var canvasbg = document.getElementById('canvasbg');
// canvasbg.width=document.body.clientWidth;
// var contextbg = canvasbg.getContext('2d');
// contextbg.fillStyle = 'rgba(0,0,0,0.7)';
// contextbg.fillRect(0,0,canvasbg.width,canvasbg.height);

var dx = $('.container').offset().left;
var dy = 60;
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

draw();
$(window).resize(function (e) {
     dx = $('.container').offset().left;
    draw();
})


function draw() {

    canvas.width=document.body.clientWidth;
    context.fillStyle = 'rgba(0,0,0,0.7)';
    context.fillRect(0,0,canvas.width,canvas.height);

    context.lineWidth=3;
    context.strokeStyle = 'rgba(255,255,255,1)';

    context.save();
    context.translate(980+dx,30);
    context.rotate(-60*Math.PI/180)
    context.translate(-120,0)

    var image = new Image();
    image.src = '/solarstory/Public/image/canvasPoint.png';
    image.onload = function (e) {
        context.drawImage(image,0,0,150,150);
        context.restore();

        drawCoordinate(context);

    }
}

// context.translate(0,60)




// context.translate(1000,30);
// context.fillRect(0,0,100,30);



function drawCoordinate(context) {
    context.strokeStyle = 'rgba(0,255,255,1)';  //蓝色:x
    context.beginPath();
    context.moveTo(dx,dy)
    context.lineTo(100+dx,dy);
    context.closePath();
    context.stroke();

    context.strokeStyle = 'rgba(255,0,255,1)';  //粉色:y
    context.beginPath();
    context.moveTo(dx,dy)
    context.lineTo(dx,100+dy);
    context.closePath();

    context.stroke();
}

