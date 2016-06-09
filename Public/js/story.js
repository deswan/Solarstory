$(document).ready(function(){
	$('.popeasy').popeasy({
			trigger: '.popeasy',          // id or class of link or button to trigger modal
			olay:'div.overlay',             // id or class of overlay
			modals:'div.modal',             // id or class of modal
			animationEffect: 'fadeIn',   // overlay effect | slideDown or fadeIn | default=fadeIn
			animationSpeed: 100,            // speed of overlay in milliseconds | default=400
			moveModalSpeed: 'fast',         // speed of modal movement when window is resized | slow or fast | default=false
			background: '#333333',           // hexidecimal color code - DONT USE #
			opacity: 0.5,                   // opacity of modal |  0 - 1 | default = 0.8
			openOnLoad: false,              // open modal on page load | true or false | default=false
			docClose: true,                 // click document to close | true or false | default=true    
			closeByEscape: true,            // close modal by escape key | true or false | default=true
			moveOnScroll: true,             // move modal when window is scrolled | true or false | default=false
			resizeWindow: true,             // move modal when window is resized | true or false | default=false
			close:'.closeBtn'               // id or class of close button
		});
	var datalength=0;
	$pub = 'http://localhost/solarstory/public/';

	$img = $('.left article .articlehead img');
	
			
	$('a.tag_section[father!=0]').hide();
	$('#write a.tag_section').click(

		function(e){
			e.preventDefault();

			if($(this).hasClass('in')){
				$(this).removeClass('in');
				$('a.tag_section[father='+$(this).attr('name')+']').hide();
				var reg = new RegExp('\\s'+$(this).text()+'\\s','i');
				
				var $input = $('#write .tag_container input');

				if($input.val().match(reg)){
					$input.val($input.val().replace(reg,''));
				}
			}
			else{
				$(this).addClass('in');
				$('a.tag_section[father='+$(this).attr('name')+']').show();

				//\s就可以,\b就不行。。
				var reg = new RegExp('\\s'+$(this).text()+'\\s','i');
				
				var $input = $('#write .tag_container input');
				if(!$input.val().match(reg)){
					$input.val($input.val()+' '+$(this).text()+' ');
				}
			}
			
		}
	)
	$('#write input[type=submit][disabled]').click(function(e){
		e.preventDefault();
	})

	$('.left article .articlehead[like=true]').siblings('.main').find('.article_user').show();
	$('.left article .articlehead[like=true]').siblings('.showComment').show();
	$('.left article .articlehead[like=false]').siblings('.main').find('.article_user').hide();
	$('.left article .articlehead[like=false]').siblings('.showComment').hide();


	//喜欢操作
	$('body').on('click','.left article .articlehead[like=false]','',function(e){
		var loginStatus = $('body').attr('login');
		// e.preventDefault();
		if(loginStatus=='false'){
			$('.modal3').modal('show')
		}
		else{
			$.ajax({
				url:'http://localhost/solarstory/index.php/home/story/ajaxLikeArticle',
				async:false,
				context:e,
				success:function(e,status){
					$tar = $($(this)[0].currentTarget)
					$tar.animate({
						backgroundColor:'#292929'
					},300);
					$tar.siblings('.main').find('.article_user').show(400);
					$tar.siblings('.showComment').show(400);
					like($tar,true);
					// $(this)[0].preventDefault();
				},
				data:"articleid="+$(this).attr('id')+"&&like=true",
				dataType:'json'
			})
		}
	})
	$('body').on('click','.left article .articlehead[like=true]','',function(e){
		var loginStatus = $('body').attr('login');
		$.ajax({
				url:'http://localhost/solarstory/index.php/home/story/ajaxLikeArticle',
				async:false,
				context:e,
				success:function(e,status){
					$tar = $($(this)[0].currentTarget)
					$tar.animate({
						backgroundColor:'#f8f8ff'
					},300);
					$tar.siblings('.main').find('.article_user').hide(400);
					$tar.siblings('.showComment').hide(400);
					$tar.siblings('.comment').hide(400);
					like($tar,false);
					// $(this)[0].preventDefault();
				},
				data:"articleid="+$(this).attr('id')+"&&like=false",
				dataType:'json'
			})
	})

	//展开评论
	$('body').on('click',".comment form input[type=submit]",'',function(e){
		e.preventDefault();
		var $comment = $(this).parents('.comment');
		var $section_node = $comment.find('.commentsection'); 
		$.ajax({
		    	url:'http://localhost/solarstory/index.php/home/story/ajaxCommitComment',
				// async:true,
				context:$(this),
				success:function(data,status){
					// alert('ss')
					$(this).siblings('input[type=text]').val('');
					datalength=data['count'];
					$section_node.empty();
					$comment.find('nav ul').empty();
					for(var i=0;i<data['comment'].length;i++){
						if(!data['comment'][i].iflike){
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/homestory?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'</p></div></div>');
						}
						else{
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/homestory?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'<a class=delete commentid='+data['comment'][i].id+'>删除</a></p></div></div>');
						}
						$node.appendTo($section_node);
					}
					createNav(datalength,1).appendTo($comment.find('nav ul'));
					updateCommentCount($comment);
				},
				data:"articleid="+$(this).parent().find('input[type=hidden]').val()+
					"&text="+$(this).parent().find('input[type=text]').val(),
				dataType:'json',
				type:'POST'
		    })
	
	})
	
	//导航（故事）
	$(".leftnav ul a:nth-child(2)[href='#']").click(function(e){
		e.preventDefault();
		$('.modal3').modal('show');
	})
	$('.left article .comment').hide();
	$('body').on('click','.left article .showComment','',function(e){
		e.preventDefault();
	    $articlehead = $(this).siblings(".articlehead");
	    $comment = $(this).siblings('.comment');
	    $section_node = $comment.find('.commentsection');
	    var $node;
	    if($comment.is(':hidden')){
		    if($articlehead.attr('like')=='false') return;	//弱保护
		    $.ajax({
		    	url:'http://localhost/solarstory/index.php/home/story/ajaxGetComments',
				async:true,
				context:$(this),
				success:function(data,status){
					datalength=data['count'];
					for(var i=0;i<data['comment'].length;i++){
						if(!data['comment'][i].iflike){
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/homestory?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'</p></div></div>');
						}
						else{
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/homestory?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'<a href=# class=delete commentid='+data['comment'][i].id+'>删除</a></p></div></div>');
						}						$node.appendTo($section_node);
					}
					//展开评论->第一页
					createNav(datalength,1).appendTo($comment.find('nav ul'));
					//若无评论show信息
					if(datalength==0){
						$comment.find('.commentEmpty').show();
					}
					$comment.fadeIn(300);
				},
				data:"articleid="+$(this).attr('id')+"&page=1",
				dataType:'json'
		    })
		}
		else{
			$comment.find('.commentdetail').remove();
			$comment.find('nav ul').empty();
			$comment.hide();
		}
	})
	
	//数字跳转块
	$('body').on('click',".comment nav li a:not([aria-label])",'',function(e){

		e.preventDefault();
		var $to = $(this).text();	//页码数字
		var $comment = $(this).parents('.comment');
		var $section_node = $comment.find('.commentsection'); 
		$.ajax({
	    	url:'http://localhost/solarstory/index.php/home/story/ajaxGetComments',
			async:true,
			context:$(this),
			success:function(data,status){
				datalength=data['count'];
				$section_node.empty();	//清空原有内容
				$comment.find('nav ul').empty();	//清空导航
				for(var i=0;i<data['comment'].length;i++){
						//若是自己发的评论可删除
						if(!data['comment'][i].iflike){
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'</p></div></div>');
						}
						else{
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'<a href=# class=delete commentid='+data['comment'][i].id+'>删除</a></p></div></div>');
						}					$node.appendTo($section_node);
				}
				createNav(datalength,$to).appendTo($comment.find('nav ul'));
			},
			data:"articleid="+$(this).parents('.comment').siblings('.showComment').attr('id')+"&page="+$to,
			dataType:'json'
	    })
	})
	//上一页
	$('body').on('click',".comment nav li:not('.disabled') a[aria-label=Previous]",'',function(e){

		e.preventDefault();
		//通过.active获取当前页码数字
		var $current = parseInt($(this).parents('.comment').find('ul li.active').find('a').text());
		var $comment = $(this).parents('.comment');
		var $section_node = $comment.find('.commentsection'); 
		$.ajax({
	    	url:'http://localhost/solarstory/index.php/home/story/ajaxGetComments',
			// async:true,
			context:$(this),
			success:function(data,status){
				datalength=data['count'];
				$section_node.empty();
				$comment.find('nav ul').empty();
				for(var i=0;i<data['comment'].length;i++){
						if(!data['comment'][i].iflike){
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'</p></div></div>');
						}
						else{
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'<a href=# class=delete commentid='+data['comment'][i].id+'>删除</a></p></div></div>');
						}					$node.appendTo($section_node);
				}
				createNav(datalength,$current-1).appendTo($comment.find('nav ul'));
			},
			data:"articleid="+$(this).parents('.comment').siblings('.showComment').attr('id')+"&page="+($current-1),
			dataType:'json'
	    })
	})
	//下一页
	$('body').on('click',".comment nav li:not('.disabled') a[aria-label=Next]:not('.disabled')",'',function(e){

		e.preventDefault();
		var $current = parseInt($(this).parents('.comment').find('ul li.active').find('a').text());
		var $comment = $(this).parents('.comment');
		var $section_node = $comment.find('.commentsection'); 
		$.ajax({
	    	url:'http://localhost/solarstory/index.php/home/story/ajaxGetComments',
			async:true,
			context:$(this),
			success:function(data,status){
				datalength=data['count'];
				$section_node.empty();
				$comment.find('nav ul').empty();
				for(var i=0;i<data['comment'].length;i++){
						if(!data['comment'][i].iflike){
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'</p></div></div>');
						}
						else{
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'<a href=# class=delete commentid='+data['comment'][i].id+'>删除</a></p></div></div>');
						}					
						$node.appendTo($section_node);
				}
				createNav(datalength,$current+1).appendTo($comment.find('nav ul'));

			},
			data:"articleid="+$(this).parents('.comment').siblings('.showComment').attr('id')+"&page="+($current+1),
			dataType:'json'
	    })
	})
	$('body').on('click',".comment .delete",'',function(e){
		e.preventDefault();
		var commentid = $(this).attr('commentid');
		var $comment = $(this).parents('.comment');
		var $section_node = $comment.find('.commentsection'); 
		$.ajax({
		    	url:'http://localhost/solarstory/index.php/home/story/ajaxDeleteComment',
				context:$(this),
				success:function(data,status){
					$(this).siblings('input[type=text]').val('');
					datalength=data['count'];
					$section_node.empty();
					$comment.find('nav ul').empty();
					for(var i=0;i<data['comment'].length;i++){
						if(!data['comment'][i].iflike){
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'</p></div></div>');
						}
						else{
							$node = $('<div class=commentdetail ><hr><div class=commentleft><img src='+$pub+data['comment'][i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data['comment'][i].uid+'>'+data['comment'][i].username+'</a>：'+data['comment'][i].text+'</p><p class=date>发表于：'+data['comment'][i].time+'<a href=# class=delete commentid='+data['comment'][i].id+'>删除</a></p></div></div>');
						}
						$node.appendTo($section_node);
					}
					createNav(datalength,1).appendTo($comment.find('nav ul'));
					updateCommentCount($comment);
				},
				data:"commentid="+commentid,
				dataType:'json',
		    })
	})
	function updateCommentCount($comment){
		$articleid = $comment.siblings('.showComment').attr('id')
		$.ajax({
		    	url:'http://localhost/solarstory/index.php/home/story/ajaxCountComment',
				context:$(this),
				success:function(data,status){
					$comment.siblings('.showComment').find('span').text('（'+data+'）');
				},
				data:"articleid="+$articleid,
				dataType:'json',
		    })
		
	}
	function createComments(start,limit){
		$node = $('<div class=commentdetail><hr><div class=commentleft><img src='+$pub+data[i].imgurl+'></div><div class=commentright><p class=commenttext><a href=http://localhost/solarstory/index.php/home/story/home?uid='+data[i].uid+'>'+data[i].username+'</a>：'+data[i].text+'</p><p class=date>发表于：'+data[i].time+'</p></div></div>');
		$node.appendTo($section_node);
	}

	//拼接li (注意只有li)
	function createNav(datalength,current){
		var length = parseInt((datalength-1)/10)+1;		//有几页

		var nodetxt = '';
		if(current>1){
			nodetxt += '<li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		}
		else{
			nodetxt += '<li class=disabled><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		}
		for(var i=current-4;i<=current+4;i++){
			if(i>0&&i<=length){
				if(i==current){
					nodetxt += '<li class=active><a href=#>'+i+'</a></li>';
				}else{
					nodetxt += '<li><a href=#>'+i+'</a></li>';
				}
			}
		}
		if(current<length){
			nodetxt += '<li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>'
		}
		else{
			nodetxt += '<li class=disabled><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>'

		}
		return $(nodetxt);	
	}
	$('body').on('click',"nav li.disabled a",'',function(e){
		
		e.preventDefault();
	})
	$('.container>.left .users .likerecords').hide();
	$('.container>.left .users .dropmenu').click(function(e){
		e.preventDefault();
		$(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		$users = $(this).parents('.users');
		$likerecords = $users.find('.likerecords');
		$nav = $likerecords.find('nav');
		if($likerecords.is(':hidden')){
			if($users.hasClass('belike')) {
				$.ajax({
					url: 'http://localhost/solarstory/index.php/home/story/ajaxLikeRecord',
					async: true,
					context: $(this),
					success: function (data, status) {
						datalength = data['count'];
						for (var i = 0; i < data['articles'].length; i++) {
							createUsers(data['articles'][i], data.ifmyhome).insertBefore($nav);
						}
						createNav(datalength, 1).appendTo($users.find('nav ul'));
						$likerecords.fadeIn(300);
					},
					data: 'idlike=' + parseInt($(this).data('idlike')) + '&belikeid=' + parseInt($(this).data('belikeid')),
					dataType: 'json'
				})
			}
			else if($users.hasClass('tolike')) {
				$.ajax({
					url: 'http://localhost/solarstory/index.php/home/story/ajaxLikeRecord',
					async: true,
					context: $(this),
					success: function (data, status) {
						datalength = data['count'];

						for(var i=0;i<data['articles'].length;i++){
							createUsers(data['articles'][i],data.ifmyhome,true).insertBefore($nav);
						}
						createNav(datalength, 1).appendTo($users.find('nav ul'));
						$likerecords.fadeIn(300);
					},
					data: 'idlike=' + parseInt($(this).data('idlike')) + '&belikeid=' +
						parseInt($(this).data('belikeid'))+'&my=true',
					dataType: 'json'
				})
			}
		}
		else{
			$(this).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
			$likerecords.hide();
			$likerecords.find('.likerecord').remove();
			$likerecords.find('nav ul').empty();
		}
	})
	$('body').on('click',".container>.left .users nav li a:not([aria-label])",'',function(e){
		e.preventDefault();
		var to = $(this).text();
		dealUsersNav($(this),to)
	})
	$('body').on('click',".container>.left .users nav li:not('.disabled') a[aria-label=Previous]",'',function(e){
		e.preventDefault();
		$users = $(this).parents('.users');
		var to = $users.find('nav li.active').text()-1;
		dealUsersNav($(this),to)
	})
	$('body').on('click',".container>.left .users nav li:not('.disabled') a[aria-label=Next]",'',function(e){
		e.preventDefault();
		$users = $(this).parents('.users');
		var to = $users.find('nav li.active').text()+1;
		dealUsersNav($(this),to)
	})
	function dealUsersNav($li,toPage){
		$users = $(this).parents('.users');
		$likerecords = $users.find('.likerecords');
		$dropmenu = $users.find('.dropmenu');
		$.ajax({
	    	url:'http://localhost/solarstory/index.php/home/story/ajaxLikeRecord',
			async:true,
			context:$(this),
			success:function(data,status){
				datalength=data['count'];
				$likerecords.find('.likerecord').remove();
			$likerecords.find('nav ul').empty();
				if($users.hasClass('belike')){
					for(var i=0;i<data['articles'].length;i++){
						createUsers(data['articles'][i],data.ifmyhome).insertBefore($nav);
					}
				}
				else if($users.hasClass('tolike')){
					for(var i=0;i<data['articles'].length;i++){
						createUsers(data['articles'][i],data.ifmyhome,true).insertBefore($nav);
					}
				}
				createNav(datalength,toPage).appendTo($users.find('nav ul'));
			},
			data:'idlike='+$dropmenu.data('idlike')+'&belikeid='+$dropmenu.data('belikeid'),
			dataType:'json'
	    })
	}
	function createUsers(data,ifmyhome){
		console.log(data)
		//未加文章id:data.id
		var tolike = arguments[2]?arguments[2]:false;
		var text = '';
		var who = '';
		if(ifmyhome){
			who='我'
		}
		else{
			who='他'
		}

		text = '<div class=likerecord><p class=liketext>于 '+data.time+' 关注了'+who+'的故事</p><p class=articletext>'+data.text+'</p><div class=clean></div></div>'
		if(tolike){
			text = '<div class=likerecord><p class=liketext>'+who+'于 '+data.time+' 关注了该用户的故事</p><p class=articletext>'+data.text+'</p><div class=clean></div></div>'
		}
		return $(text);
	}
	function like($article,like){
		if(like==true){
			$article.attr('like','true');
		}
		else{
			$article.attr('like','false');
		}
	}
	
	$('.search span').click(function(e){
		$(this).parents('form').submit();
	})
	
	
	$('.modal2 input[name=username]').blur(function () {
		var warning=0;
		var value = $(this).val();
		if(value) {
			var ifUsernameExist=false;

			if(value.match(/[^\w\u4e00-\u9fa5]/)){
				warning='只能包含数字,字母,中文或下划线'
			}
			if(value.length<3||value.length>10){
				warning='字符数限制在3-10个'
			};
			$.ajax({
				url: 'http://localhost/solarstory/index.php/home/user/ajaxifUsernameExist',
				async:false,
				success: function (data, status) {
					if (data == 1) {
						ifUsernameExist = true;
					}
				},
				data: "name=" + value,
				dataType: 'json'
			})
			if(ifUsernameExist) warning='用户名已存在';
			console.log(warning);
		}
		else{
			warning='用户名不能为空!'
		}
		if(warning){
			$(this).siblings('span').find('i').css('color','orange');
			$node = $('<p class="warning"><i class="glyphicon glyphicon-minus-sign"></i>'+warning+'</p>');
			$(this).parents('fieldset').find('.warning').remove();
			$(this).parent().after($node);
		}
		else{
			$(this).siblings('span').find('i').css('color','green');
			$(this).parents('fieldset').find('.warning').remove();
		}
	})
	$('.modal2 input[name=password]').blur(function () {
		var warning=0;
		var value = $(this).val();
		if(value) {
			if(value.match(/[^\w]/)){
				warning='只能包含数字,字母或下划线'
			}
			if(value.length<5||value.length>15){
				warning='字符数限制在5-15个'
			};
		}
		else{
			warning='密码不能为空!'
		}
		if(warning){
			$(this).siblings('span').find('i').css('color','orange');
			$node = $('<p class="warning"><i class="glyphicon glyphicon-minus-sign"></i>'+warning+'</p>');
			$(this).parents('fieldset').find('.warning').remove();
			$(this).parent().after($node);
		}
		else{
			$(this).siblings('span').find('i').css('color','green');
			$(this).parents('fieldset').find('.warning').remove();
		}
	})
	$('.modal2 input[name=verify]').blur(function () {
		var warning=0;
		var value = $(this).val();
		if(value) {
			$.ajax({
				url: 'http://localhost/solarstory/index.php/home/user/ajaxCheckVerify',
				async:false,
				success: function (data, status) {
					console.log(data)
					if (!data) {
						warning='验证码不正确'
					}
				},
				data: "code=" + value,
				dataType: 'json'
			})
		}
		else{
			warning='验证码不能为空!'
		}
		if(warning){
			$(this).siblings('span').css('color','orange');
			$node = $('<p class="warning"><i class="glyphicon glyphicon-minus-sign"></i>'+warning+'</p>');
			$(this).parents('fieldset').find('.warning').remove();
			$(this).parent().after($node);
		}
		else{
			console.log('ss')
			$(this).siblings('span').css('color','green');
			$(this).parents('fieldset').find('.warning').remove();
		}
	})
	
	$('[data-toggle=modal]').click(function () {
		$('img.code').click();
	})
});