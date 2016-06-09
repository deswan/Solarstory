<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset=utf-8>
	<title></title>
	<link rel="stylesheet" type="text/css" href="/solarstory/Public/css/font-awesome-4_5/css/font-awesome_min.css" />
	<link rel="stylesheet" type="text/css" href="/solarstory/Public/css/bootstrap_min.css" />
	<link rel="stylesheet" type="text/css" href="/solarstory/Public/css/story.css" />

</head>
<body class="story"
<?php if(empty($userInform)): ?>login=false<?php endif; ?>
<?php if(!empty($userInform)): ?>login=true<?php endif; ?>
>

<div class='storybg'></div>

<div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<div class="modal-body">
				<form class="form-1" action=<?php echo U('user/login');?> method="post">

					<h2>登陆</h4>

						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
						</div>

						<div class="input-group">
							<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password" name="username" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
						</div>
						<fieldset>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon3">验证码</span>
							<input type="text" name="verify" class="form-control" placeholder="" aria-describedby="basic-addon2">
						</div>
</fieldset>
						<img class="code" src="<?php echo U('story/code');?>" width=120px onclick="this.src=this.src">

						<div class="btn-group btn-group-justified" role="group" aria-label="...">
							<div class="btn-group" role="group" aria-label="...">
								<input value="登陆" class="btn btn-danger " type="submit">
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade modal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body clearfix">
				<form class="form-1 signup" action=<?php echo U('user/signup');?> method="post">

					<h2>注册</h2>
					<fieldset>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon4"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
					</div>
						</fieldset>
					<fieldset>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon5"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" name="password" name="username" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
					</div>
					</fieldset>
					<fieldset>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon6">验证码</span>
						<input type="text" name="verify" class="form-control" placeholder="" aria-describedby="basic-addon2">
					</div>
						</fieldset>

					<img class="code" src="<?php echo U('story/code');?>" width=120px onclick="this.src=this.src">

					<div class="btn-group btn-group-justified" role="group" aria-label="...">
						<div class="btn-group" role="group" aria-label="...">
							<input value="立即注册" class="btn btn-warning " type="submit" >
						</div>
					</div>
				</form>
				<div id="intro">
					<p>欢迎来到这个节气故事的聚集地</p>
					<p>注册之后您可以:</p>
					<ul>
						<li>关注您喜欢的故事</li>
						<li>查看您关注的故事的评论</li>
					</ul>
					<p>去发掘更多的故事吧<!doctype html>
						<html lang="en">
						<head>
							<meta charset="UTF-8">
							<title>Document</title>
						</head>
						<body>
						
						</body>
						</html></p>
				</div>
			</div>

		</div>
	</div>
</div>



<div class="modal fade modal3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">您还未登陆</h4>
			</div>
			<!-- <div class="modal-body">
              您还未登陆
            </div> -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!--  <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>

<header class="navTop">
	<ul>
		<li><a>日历</a></li>
		<li><a>新闻</a></li>
		<li><a>Logo</a></li>
		<li><a>节 · 气</a></li>
		<li><a>黄道</a></li>
		<li><a href="story.html">故事</a></li>
	</ul>
</header>
<div class="clear"></div>
<div class="container">

<div class='leftnav'>
    <ul>
        <a href=<?php echo U('story/index');?>><li>首页<i class="glyphicon glyphicon-home"></i></li></a>
        <?php if(!empty($userInform)): ?><a href=<?php echo U('story/homestory',['uid'=>$userInform['id']]);?>><li>故事<i class="fa fa-pencil"></i></li></a>
            <a href=<?php echo U('story/likeBeStory',['uid'=>$userInform['id']]);?>><li>新的关注<i class="fa fa-star"></i></li></a>
            <a href=<?php echo U('story/commentout');?>><li>评论<i class="glyphicon glyphicon-comment"></i></li></a>
            <a href=<?php echo U('story/my');?> class='active'><li>个人资料<i class="fa fa-pencil"></i></li></a><?php endif; ?>
    </ul>
</div>
<div class="left">
    <div class="panel panel-default editpicture">
        <div class="panel-heading">
            <h3 class="panel-title">编辑头像</h3>
        </div>
        <div class="panel-body">
            <img src=/solarstory/Public/<?php echo ($imgurl); ?> class="picture">
            <div class="detail">
                <button type="button" id="pictureUpload" class="btn btn-primary btn-lg">上传头像</button>
            </div>
        </div>
    </div>
</div>



<div class="right">
	<div class="user">
		<!-- 数据库里id值为零时有问题，所以手动设1先 -->
		<?php if(!empty($userInform)): ?><div class="userinformation">
				<img src=/solarstory/Public/<?php echo ($userInform['imgurl']); ?>>
				<h3><?php echo ($userInform['username']); ?></h3>

			</div>
			<a id='logout' href=<?php echo U('user/logout');?>>退出</a><?php endif; ?>

	</div>
	<div class="search">
		<form method="get" action="/solarstory/index.php/home/story/search">
			<div class="input-group">

				<input type="text" class="form-control" name="key" placeholder="搜索标签" aria-describedby="sizing-addon2">
				<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
			</div>
		</form>
	</div>
	<div class="tags">
		<!--<h2>标签</h2>-->
		<?php if(is_array($navtags)): $i = 0; $__LIST__ = $navtags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><a href="<?php echo U('story/indextag',['tagid'=>$tag['id']]);?>" class="btn btn-primary btn-xs" role="button">
				<?php echo ($tag["name"]); ?> <span class="badge"><?php echo ($tag["hits"]); ?></span>
			</a>
			<br><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
</div>
</div>
	<script type="text/javascript" src="/solarstory/Public/js/jQuery.js"></script>
	<script type="text/javascript" src="/solarstory/Public/js/jquery_animate-colors-min.js"></script>
	
	<script type="text/javascript" src="/solarstory/Public/js/jquery_popeasy.js"></script>
	<script type="text/javascript" src="/solarstory/Public/js/story.js"></script>
	<script type="text/javascript" src="/solarstory/Public/js/bootstrap_min.js"></script>
</body>
</html>
<script src="/solarstory/Public/js/plupload/plupload.full.min.js"></script>
<script>
    //实例化一个plupload上传对象
    var uploader = new plupload.Uploader({
        browse_button : 'pictureUpload', //触发文件选择对话框的按钮，为那个元素id
        url : '/solarstory/index.php/home/story/pictureUpload', //服务器端的上传页面地址
        filters: {
            mime_types : [ //只允许上传图片和zip文件
                { title : "Image files", extensions : "jpg,gif,png,jpeg" },
            ],
            max_file_size : '2048kb',
            prevent_duplicates : true //不允许选取重复文件
        },
        multi_selection:false,
        file_data_name:'picture'
    });

    //在实例对象上调用init()方法进行初始化
    uploader.init();

    //绑定各种事件，并在事件监听函数中做你想做的事
    uploader.bind('FilesAdded',function(uploader,files){
        uploader.start();
        $progress_bar = $('<div class="progress"> <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"> </div></div>');
        $('.editpicture').find('.detail').append($progress_bar);
    });
    uploader.bind('UploadProgress',function(uploader,file){
        console.log(file.percent);
        $progress_bar = $('.progress-bar');
        $progress_bar.css('width',file.percent+'%');
    });
    uploader.bind('UploadComplete',function(uploader,file){
//        console.log('file.percent');
        $('.progress-bar').remove();
        history.go(0);
    });
    uploader.bind('Error',function(uploader,err){
        console.log('err!!');
    });
    //......
    //......

    //最后给"开始上传"按钮注册事件
    //调用实例对象的start()方法开始上传文件，当然你也可以在其他地方调用该方法

</script>