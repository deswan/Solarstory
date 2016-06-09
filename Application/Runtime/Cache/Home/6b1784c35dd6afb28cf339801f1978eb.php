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
			<a href=<?php echo U('story/likeBeStory',['uid'=>$userInform['id']]);?> class='active'><li>新的关注<i class="fa fa-star"></i></li></a>
			<a href=<?php echo U('story/commentout');?>><li>评论<i class="glyphicon glyphicon-comment"></i></li></a>
			<a href=<?php echo U('story/my');?>><li>个人资料<i class="fa fa-pencil"></i></li></a><?php endif; ?>
	</ul>
</div>
		<div class="left" style="padding-left: 20px">
			<?php if($articles == 0): ?><div class="articleEmpty">您还没有被关注过</div><?php endif; ?>
			<?php if(is_array($articles)): $i = 0; $__LIST__ = $articles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><div class=mycomment>
					<div class="left"><img src=/solarstory/Public/<?php echo ($user["imgurl"]); ?>></div>
					<div class="right">
						<p class=commenttext>用户 <a href=<?php echo U('story/homestory',['uid'=>$user['id']]);?>><?php echo ($user["username"]); ?></a> 关注了你的故事
							<?php if(empty($$user['hasRead'])): ?><span class="label label-warning">New</span><?php endif; ?>
						</p>

						<p class=time><?php echo (dateConvert('date',$user["time"])); ?></p>
						<p class=totext>"<?php echo ($user["text"]); ?>"</p>
					</div>
					<div class='clean'></div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			<nav style="text-align: center">
			  <ul class="pagination">
				  <?php if($currentpage>1){ ?>
				  <li>
					  <a href=<?php echo U('story/index',['page'=>$currentpage-1]);?> aria-label="Previous">
						  <span aria-hidden="true">&laquo;</span>
					  </a>
				  </li>
				  <?php } ?>
				  <?php for($i=$currentpage-4;$i<$currentpage+4;$i++){ if($i>0&&$i<$articlepage+1){ ?>

				  <li
				  <?php if($i==$currentpage){ ?>
				  class=active
				  <?php } ?>
				  >
				  <a href=
							 <?php echo "http://localhost/solarstory/index.php/Home/story/index/page/".$i ?>
					  >
					  <?php echo $i ?>
				  </a>
				  </li>

				  <?php }} ?>
				  <?php if($currentpage<$articlepage){ ?>
				  <li>
					  <a href=<?php echo U('story/index',['page'=>$currentpage+1]);?> aria-label="Next">
						  <span aria-hidden="true">&raquo;</span>
					  </a>
				  </li>
				  <?php } ?>
			  </ul>
			</nav>
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