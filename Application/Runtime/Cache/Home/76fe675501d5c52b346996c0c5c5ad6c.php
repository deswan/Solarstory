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

						<div class="input-group">
							<span class="input-group-addon" id="basic-addon3">验证码</span>
							<input type="text" name="verify" class="form-control" placeholder="" aria-describedby="basic-addon2">
						</div>

						<img src="<?php echo U('story/code');?>" width=120px onclick="this.src=this.src">

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
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<div class="modal-body">
				<form class="form-1" action=<?php echo U('user/signup');?> method="post">

					<h2>注册</h4>

						<div class="input-group">
							<span class="input-group-addon" id="basic-addon4"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
						</div>

						<div class="input-group">
							<span class="input-group-addon" id="basic-addon5"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password" name="username" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
						</div>

						<div class="input-group">
							<span class="input-group-addon" id="basic-addon6">验证码</span>
							<input type="text" name="verify" class="form-control" placeholder="" aria-describedby="basic-addon2">
						</div>

						<img src="<?php echo U('story/code');?>" width=120px onclick="this.src=this.src">

						<div class="btn-group btn-group-justified" role="group" aria-label="...">
							<div class="btn-group" role="group" aria-label="...">
								<input value="立即注册" class="btn btn-warning " type="submit" >
							</div>
						</div>
				</form>
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
					<a href=<?php echo U('story/commentout');?> class='active'><li>评论<i class="glyphicon glyphicon-comment"></i></li></a><?php endif; ?>
				<?php if(empty($userInform)): ?><a href='#'><li>故事<i class="fa fa-pencil"></i></li></a>
					<a href="#"><li>新的关注<i class="fa fa-star"></i></li></a>
					<a href="#"><li>评论<i class="glyphicon glyphicon-comment"></i></li></a><?php endif; ?>

			</ul>
		</div>	
		<div class="left">

			<div class="homehead">
				<!-- <div class="placeholder"></div> -->
				<div class="userinformation">
					<img src="/solarstory/Public/<?php echo ($currentUserInform["imgurl"]); ?>">
					<h3><?php echo ($currentUserInform["username"]); ?></h3>
					<div class='homeheadcontainer'>
						<p class="num"><?php echo ((isset($currentUserInform["storynum"]) && ($currentUserInform["storynum"] !== ""))?($currentUserInform["storynum"]):0); ?></p>
						<p class="title">故事</p>
					</div>
					<div class='homeheadcontainer'>
						<p class="num"><?php echo ((isset($currentUserInform["likenum"]) && ($currentUserInform["likenum"] !== ""))?($currentUserInform["likenum"]):0); ?></p>
						<p class="title">关注度</p>
					</div>
					<div class="placeholder"></div>
				</div>
			</div>
			<div class="homebanner">
				<div class="btn-group btn-group-justified" role="group" aria-label="...">
					<div class="btn-group" role="group" aria-label="...">
					<a href=<?php echo U('story/commentout');?> class="commentbtn btn btn-default" type="button" role='button'>
						  发出的评论
					</a>
					</div>
					<div  class="btn-group" role="group" aria-label="...">
					<a href=<?php echo U('story/commentin');?> class="active commentbtn btn btn-default" type="button" role='button'>
						 收到的评论
					</a>
					</div>
				</div>
			</div>

			<?php if($comments == 0): ?><div class="articleEmpty">没有可显示的评论</div><?php endif; ?>
			<?php if(is_array($comments)): $i = 0; $__LIST__ = $comments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comment): $mod = ($i % 2 );++$i;?><div class=mycomment>
					<div class="left"><img src=/solarstory/Public/<?php echo ($comment["imgurl"]); ?>></div>
					<div class="right">
						<p class=name><?php echo ($comment["username"]); ?></p>
						<p class=time><?php echo (dateConvert('date',$comment["time"])); ?></p>
						<p class=commenttext><?php echo ($comment["commenttext"]); ?></p>
						<p class=totext>评论我的故事：<?php echo ($comment["articletext"]); ?></p>
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
			<div class="tags">
				<h2>Tags</h2>
				<?php if(is_array($navtags)): $i = 0; $__LIST__ = $navtags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><!-- 	<a href="<?php echo U('story/index',['tagid'=>$tag['id']]);?>"><?php echo ($tag["name"]); ?>(<?php echo ($tag["hits"]); ?>)</a> -->
			<a href="<?php echo U('story/indextag',['tagid'=>$tag['id']]);?>" class="btn btn-primary btn-xs" role="button">
			  <?php echo ($tag["name"]); ?> <span class="badge"><?php echo ($tag["hits"]); ?></span>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
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