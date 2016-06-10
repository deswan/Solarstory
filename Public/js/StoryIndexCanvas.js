/**
 * Created by desire on 16/6/9.
 */

var dx = $('.container').offset().left;
var topY=60;    //navTop的距离
var status=1;   //当前页
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
canvas.width=document.body.clientWidth;

draw(status);
$(window).resize(function (e) {
    dx = $('.container').offset().left;
    canvas.width=document.body.clientWidth;
    draw(status);
})

$('#canvas').mousemove(function(e){
    var x = e.pageX-dx;
    var y = e.pageY-topY;
    if(status!=7) {
        if ((x < 775 + 50 && x > 775 - 50) && (y > 460 - 30 && y < 460 + 30)) {
            $(this).css('cursor', 'pointer');
        }
        else{$(this).css('cursor','default')}
    }else{
        if ((x < 440 + 100 && x > 440 - 100) && (y > 340 - 30 && y < 340 + 30)) {
            $(this).css('cursor', 'pointer');
        }
        else{$(this).css('cursor','default')}
    }
})

//禁止滚动(拙劣)
$(window).scroll(function (e) {
    $(this).scrollTop(0);
});

function draw(status) {
    console.log(status)
    status = parseInt(status)
    switch (status) {
        case 1:drawPageOne();break;
        case 2:drawPageTwo();break;
        case 3:drawPageThree();break;
        case 4:drawPageFour();break;
        case 5:drawPageFive();break;
        case 6:drawPageSix();break;
        case 7:drawPageSeven();break;
    }
}

function redraw(context) { //清屏
    console.log('aa')
    context.clearRect(0,0,canvas.width,canvas.height)
    context.fillStyle = 'rgba(0,0,0,0.9)';
    context.fillRect(0,0,canvas.width,canvas.height);
}

function drawPageOne() {
    //绘制人物
    redraw(context);
    var girl = new Image();
    girl.src = '/solarstory/Public/image/canvasGirl.png';
    girl.onload = function (e) {
        context.save();
        context.translate(500+dx,100)
        context.scale(-1,1)
        context.drawImage(girl,0,0,300,420);
        context.restore();

        //绘制气泡
        var paopao = new Image();
        paopao.src = '/solarstory/Public/image/canvasPaoPao.png';
        paopao.onload = function (e) {
            context.save();
            context.translate(750+dx,40)
            context.scale(-1,1)
            context.drawImage(paopao,0,0,300,280);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.translate(520+dx,150)

            context.fillText('欢迎来到节气的故事',0,0)
            context.fillText('这里是一个故事的聚集地',0,20)
            context.restore();

            drawNav(1);
        }
    }
    $('#canvas').click(function(e){
        var x = e.pageX-dx;
        var y = e.pageY-topY;
        if((x<775+50&&x>775-50)&&(y>460-30&&y<460+30)){
            status=2;
            draw(2);
        }
    })

}

function drawNav(cpage) {
    var text='';
    switch (cpage){
        case 1:text='功能介绍';break;
        case -1:text='开始我的故事之旅';break;
        default:text='Next';break;
    }
    //绘制文字框
    var textFrame = new Image();
    textFrame.src = '/solarstory/Public/image/canvasText.png';
    textFrame.onload = function (e) {
        if(cpage==-1){
            context.save();
            context.translate(650+dx,280)
            context.scale(-1.7,1.0)
            context.drawImage(textFrame,0,0,250,120);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.textAlign='center';
            context.textBaseline = 'middle';
            context.translate(440+dx,340)
            context.font = '16px verdana';
            context.fillText(text,0,0);
            context.restore()
        }
        else{
            context.save();
            context.translate(900+dx,400)
            context.scale(-1,1)
            context.drawImage(textFrame,0,0,250,120);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.textAlign='center';
            context.textBaseline = 'middle';
            context.translate(775+dx,457)
            context.font = '20px verdana';
            context.fillText(text,0,0);
            context.restore()

        }
    }
}

function drawPageThree() {
    //绘制人物
    redraw(context);
    $('#canvas').off('click');
    var girl = new Image();
    girl.src = '/solarstory/Public/image/canvasGirl.png';
    girl.onload = function (e) {
        context.save();
        context.translate(900+dx,100)
        context.drawImage(girl,0,0,200,280);
        context.restore();

        //绘制气泡
        var paopao = new Image();
        paopao.src = '/solarstory/Public/image/canvasPaoPao.png';
        paopao.onload = function (e) {
            context.save();
            context.translate(630+dx,0)
            context.drawImage(paopao,0,0,300,280);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.translate(720+dx,120)

            context.fillText('大家的故事在这里',0,0)
            context.fillText('被浏览与发现',0,20)
            context.restore();

            //擦除注册矩形
            context.save();
            context.translate(170+dx,250);
            context.beginPath();
            context.rect(0,0,700,160);
            context.clip();
            context.clearRect(0,0,canvas.width,canvas.height);
            context.restore();

            drawNav(3);

            $('#canvas').click(function(e){
                var x = e.pageX-dx;
                var y = e.pageY-topY;
                if((x<775+50&&x>775-50)&&(y>460-30&&y<460+30)){
                    status=4;
                    draw(4);
                }
            })
        }
    }

}


function drawPageTwo() {
    //绘制人物
    redraw(context);
    $('#canvas').off('click');
    var girl = new Image();
    girl.src = '/solarstory/Public/image/canvasGirl.png';
    girl.onload = function (e) {
        context.save();

        context.translate(160+dx,300)
        context.scale(-1,1)
        context.drawImage(girl,0,0,200,280);
        context.restore();

        //绘制气泡
        var paopao = new Image();
        paopao.src = '/solarstory/Public/image/canvasPaoPao.png';
        paopao.onload = function (e) {
            context.save();
            context.translate(500+dx,200)
            context.scale(-1.2,1.2)
            context.drawImage(paopao,0,0,300,280);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.translate(230+dx,340)

            context.fillText('如果你有与时节有关的心情',0,0)
            context.fillText('或者故事可以在这里发表,',0,20)
            context.fillText('寻找有相同经历的知己',0,40)
            context.restore();

            //擦除注册矩形
            context.save();
            context.translate(160+dx,30);
            context.beginPath();
            context.rect(0,0,700,200);
            context.clip();
            context.clearRect(0,0,canvas.width,canvas.height);
            context.restore();

            drawNav(2);
        }
    }
    $('#canvas').click(function(e){
        var x = e.pageX-dx;
        var y = e.pageY-topY;
        if((x<775+50&&x>775-50)&&(y>460-30&&y<460+30)){
            status=3;
            redraw(context);
            draw(3);

        }
    })
}

function drawPageFour() {
    //绘制人物
    redraw(context);
    $('#canvas').off('click');
    var girl = new Image();
    girl.src = '/solarstory/Public/image/canvasGirl.png';
    girl.onload = function (e) {
        context.save();
        context.translate(700+dx,100)
        context.scale(-1.3,1.3)
        context.drawImage(girl,0,0,200,280);
        context.restore();

        //绘制气泡
        var paopao = new Image();
        paopao.src = '/solarstory/Public/image/canvasPaoPao.png';
        paopao.onload = function (e) {
            context.save();
            context.translate(230+dx,0)
            context.drawImage(paopao,0,0,300,280);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.translate(310+dx,110)

            context.fillText('点击该按钮就表示你有',0,0)
            context.fillText('与这个故事相同的故事',0,20)
            context.fillText('或心情啦',0,40)
            context.restore();


            //擦除注册矩形
            context.save();
            context.translate(115+dx,255);
            context.beginPath();
            context.rect(0,0,50,40);
            context.clip();
            context.clearRect(0,0,canvas.width,canvas.height);
            context.restore();

            drawNav(3);

            $('#canvas').click(function(e){
                var x = e.pageX-dx;
                var y = e.pageY-topY;
                if((x<775+50&&x>775-50)&&(y>460-30&&y<460+30)){
                    status=5;
                    draw(5);
                }
            })
        }
    }
}

function drawPageFive() {
    //绘制人物
    redraw(context);
    $('#canvas').off('click');
    var girl = new Image();
    girl.src = '/solarstory/Public/image/canvasGirl.png';
    girl.onload = function (e) {
        context.save();

        context.translate(560+dx,100)
        context.scale(-1.5,1.5)
        context.drawImage(girl,0,0,200,280);
        context.restore();

        //绘制气泡
        var paopao = new Image();
        paopao.src = '/solarstory/Public/image/canvasPaoPao.png';
        paopao.onload = function (e) {
            context.save();
            context.translate(800+dx,50)
            context.scale(-1.0,1.0)
            context.drawImage(paopao,0,0,300,280);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.translate(580+dx,170)

            context.fillText('当然,你得先注册~',0,0)
            context.fillText('不然没有人知道你是谁',0,20)
            context.restore();

            //擦除注册矩形
            context.save();
            context.translate(985+dx,30);
            context.beginPath();
            context.rect(0,0,100,50);
            context.clip();
            context.clearRect(0,0,canvas.width,canvas.height);
            context.restore();

            drawNav(2);
        }
    }
    $('#canvas').click(function(e){
        var x = e.pageX-dx;
        var y = e.pageY-topY;
        if((x<775+50&&x>775-50)&&(y>460-30&&y<460+30)){
            status=6;
            draw(6);

        }
    })
}

function drawPageSix() {
    //绘制人物
    redraw(context);
    $('#canvas').off('click');
    var girl = new Image();
    girl.src = '/solarstory/Public/image/canvasGirl.png';
    girl.onload = function (e) {
        context.save();

        context.translate(560+dx,100)
        context.scale(-1.5,1.5)
        context.drawImage(girl,0,0,200,280);
        context.restore();

        //绘制气泡
        var paopao = new Image();
        paopao.src = '/solarstory/Public/image/canvasPaoPao.png';
        paopao.onload = function (e) {
            context.save();
            context.translate(800+dx,50)
            context.scale(-1.0,1.0)
            context.drawImage(paopao,0,0,300,280);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.translate(580+dx,170)

            context.fillText('此处还可以筛选你',0,0)
            context.fillText('感兴趣的故事类型呢',0,20)
            context.restore();

            //擦除注册矩形
            context.save();
            context.translate(870+dx,100);
            context.beginPath();
            context.rect(0,0,220,400);
            context.clip();
            context.clearRect(0,0,canvas.width,canvas.height);
            context.restore();

            drawNav(2);
        }
    }
    $('#canvas').click(function(e){
        var x = e.pageX-dx;
        var y = e.pageY-topY;
        if((x<775+50&&x>775-50)&&(y>460-30&&y<460+30)){
            status=7;
            draw(7);

        }
    })
}

function drawPageSeven() {
    //绘制人物
    redraw(context);
    $('#canvas').off('click');
    var girl = new Image();
    girl.src = '/solarstory/Public/image/canvasGirl.png';
    girl.onload = function (e) {
        context.save();

        context.translate(560+dx,100)
        context.scale(1.5,1.5)
        context.drawImage(girl,0,0,200,280);
        context.restore();

        //绘制气泡
        var paopao = new Image();
        paopao.src = '/solarstory/Public/image/canvasPaoPao.png';
        paopao.onload = function (e) {
            context.save();
            context.translate(290+dx,0)
            context.drawImage(paopao,0,0,300,280);
            context.restore();

            //绘制文本
            context.save();
            context.fillStyle = 'rgba(255,255,255,1)';
            context.font = '15px verdana';
            context.translate(360+dx,120)

            context.fillText('更多精彩等你去挖掘',0,0)
            context.fillText('赶快开启故事之旅吧~',0,20)
            context.restore();

            //擦除注册矩形
            context.save();
            context.translate(0+dx,0);
            context.beginPath();
            context.rect(0,0,165,230);
            context.clip();
            context.clearRect(0,0,canvas.width,canvas.height);
            context.restore();

            drawNav(-1);
        }
    }
    $('#canvas').click(function(e){
        var x = e.pageX-dx;
        var y = e.pageY-topY;
        if ((x < 440 + 100 && x > 440 - 100) && (y > 340 - 30 && y < 340 + 30)) {
            $.ajax({
                url:'/solarstory/index.php/home/user/ajaxAddIP'
            })
            $(this).remove();
        }
    })
}

function drawCoordinate(context) {
    context.lineWidth=3;

    context.strokeStyle = 'rgba(0,255,255,1)';  //蓝色:x
    context.beginPath();
    context.moveTo(0,0)
    context.lineTo(100,0);
    context.closePath();
    context.stroke();

    context.strokeStyle = 'rgba(255,0,255,1)';  //粉色:y
    context.beginPath();
    context.moveTo(0,0)
    context.lineTo(0,100);
    context.closePath();

    context.stroke();
}

