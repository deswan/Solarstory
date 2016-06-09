$(document).ready(function(){
	var $body = $("body");
	var fontsize = 8 * ($body.width()/ 820) + 'px';
		$('header').css('fontSize',fontsize);
	window.onresize = function(){
		var fontsize = 8 * ($body.width()/ 820) + 'px';
		$('header').css('fontSize',fontsize);
	}
	window.requestAnimFrame = (function(){
          return  window.requestAnimationFrame       ||
                  window.webkitRequestAnimationFrame ||
                  window.mozRequestAnimationFrame    ||
                  window.oRequestAnimationFrame      ||
                  window.msRequestAnimationFrame     ||
                  function(/* function */ callback, /* DOMElement */ element){
                    window.setTimeout(callback, 1000 / 60);
                  };
    })();
        function drawAFrame() {
          var context = canvas.getContext('2d');
var now = Date.now();
          context.save();
text.globalAlpha = 0.65;
            context.fillStyle = "rgb(245, 245, 245)";
            context.fillRect(0, 0, canvas.width, canvas.height);
          var now = Date.now();
          context.fillStyle = context.createPattern(rain, 'repeat');
          context.save();
          context.translate(-256 + 0.1*now % 256, -256 + now*0.2 % 256);
          context.fillRect(0, 0, canvas.width+256, canvas.height+256);
          context.restore();
          context.restore();
        }
        function loopAnimation(currentTime) {
          drawAFrame();
          window.requestAnimFrame(loopAnimation, canvas);
        }
	var canvas = document.getElementById("canvas");
	var rain = new Image();
        rain.src = "/solarstory/public/static/image/rain_black.png";
        rain.onload = function () {
          window.requestAnimFrame(loopAnimation, canvas);
        }
})
