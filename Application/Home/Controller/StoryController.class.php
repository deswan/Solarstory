<?php
namespace Home\Controller;
use Think\Controller;
class StoryController extends Controller
{
    private $articleLimit=10;
    public function code(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 18;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 130;
        $Verify->imageH = 50;
        $Verify->entry();
    }
    public function index($page=1)
    {
        $ma = D('Article');
        $mu = D('User');
        $mt = D('Tags');

        //发表文章标签
        $writetags = array_merge($mt->where('id>=1 AND id<=34')->select(),
            $mt->where('id>34')->order('hits desc')->limit(10)->select());
        $this->assign('writetags',$writetags);

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);


        //正文
        // dump($tagid);
        $userid = session('?userid') ? session('userid') : null;
        if(!isset($userid)){
            $res = $ma->getArticleForMain('','',$page);
        }else{
            $res = $ma->getArticleForMain('',$userid,$page);
        }

        if(!$res['articles']){
            $res['articles']=0;
        }

        $this->assign('articles',$res['articles']);
        $this->assign('articlepage',intval(($res['count']-1)/$this->articleLimit)+1);
        $this->assign('currentpage',$page);
        if(session('?userid')){
            $this->assign('userInform',$mu->getUserInformation(session('userid')));
        }

        $this->display();
    }
    public function indextag($tagid,$page=1)
    {
        if(!is_numeric($page)||!is_numeric($page)) return;
        $ma = D('Article');
        $mu = D('User');
        $mt = D('Tags');
        $mat = D('Article_tags');

        //发表文章标签
        $writetags = array_merge($mt->where('id>=1 AND id<=34')->select(),
            $mt->where('id>34')->order('hits desc')->limit(10)->select());
        $this->assign('writetags',$writetags);

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);


        //正文
        $userid = session('?userid') ? session('userid') : null;
        if(isset($userid)){
            $res = $ma->getArticleForMain($tagid,$userid,$page);
        }
        else{
            $res = $ma->getArticleForMain($tagid,'',$page);
        }

        if(!$res['articles']){
            $res['articles']=0;
        }

        $this->assign('tagid',$tagid);
        $this->assign('articles',$res['articles']);
        $this->assign('articlepage',intval($res['count']/$this->articleLimit));
        $this->assign('currenttagid',$tagid);
        $this->assign('currentpage',$page);
        if(session('?userid')){
            $this->assign('userInform',$mu->getUserInformation(session('userid')));
        }



        $this->display();
    }

    public function submitwrite(){
        //验证是否合法操作
        // dump(I('post.tags',''));
        if(!session('?userid')||!IS_POST||!I('post.text','')||!I('post.tags')) return;

        $MTags = D('Tags');
        $MArticle = D('Article');
        $MArticleTags = D('ArticleTags');

        $tags = I('post.tags');
        if(!$MArticle->create()){
            return $this->error($MArticle->getError());
        }
        $id = $MArticle->add();
        if(!empty($tags)){
            $arr_tagnames = array_unique(explode(' ',trim(preg_replace('/\s+/',' ',$tags))));

            $arr_tagsid = $MTags->newArticleTags($arr_tagnames);
            $MArticleTags->inserta($id,$arr_tagsid);
        }

        return $this->success('发表成功');
    }
    public function homestory($uid,$page=1){
        if(!is_numeric($uid)||!is_numeric($page)) return;
        if(!session('?userid')) return;
        $ma = D('Article');
        $mu = D('User');
        $mt = D('Tags');
        $mat = D('Article_tags');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文
        $userid = session('userid');
        $res = $ma->getArticleForHome($userid,$uid,$page);

        if(!$res['articles']){
            $res=0;
        }
        $this->assign('articles',$res['articles']);

        //分页
        $this->assign('articlepage',intval(($res['count']-1)/$this->articleLimit)+1);
        $this->assign('currentpage',$page);

        $this->assign('currentUserInform',$mu->getUserInformation($uid));   //哪个用户的主页
        $this->assign('userInform',$mu->getUserInformation($userid));       //当前的登陆状态是哪个用户

        $this->display();
    }
    public function likeToStory($uid,$page=1){
        // dump(session('userid',null));

        if(!is_numeric($uid)) return;
        if(!session('?userid')) return;
        $ma = D('Article');
        $mu = D('User');
        $mt = D('Tags');
        $mat = D('Article_tags');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文
        // dump($tagid);
        $userid = session('userid');
        $res = $ma->getArticleForHome($userid,$uid,$page,true);

        if(!$res['articles']){
            $res['articles']=0;
        }
        $this->assign('articles',$res['articles']);

        //分页
        $this->assign('articlepage',intval(($res['count']-1)/$this->articleLimit)+1);
        $this->assign('currentpage',$page);

        $this->assign('currentUserInform',$mu->getUserInformation($uid));
        $this->assign('userInform',$mu->getUserInformation($userid));

        $this->display();
    }
    public function likeToUsers($uid,$page=1){
        // dump(session('userid',null));
        if(!is_numeric($uid)) return;
        if(!session('?userid')) return;
        $ma = D('Article');
        $mu = D('User');
        $mt = D('Tags');
        $mat = D('Article_tags');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文
        // dump($tagid);
        $userid = session('userid');
        $res = $mu->getUserLikes($uid,$page);

        if(!$res['count']){
            $res['articles']=0;
        }
        $this->assign('articles',$res['articles']);
        $this->assign('articlepage',intval($res['count']/$this->articleLimit));

        $this->assign('currentUserInform',$mu->getUserInformation($uid));

        $this->assign('userInform',$mu->getUserInformation($userid));

        $this->display();
    }


    public function likeBeStory($uid,$page=1){
        if(!is_numeric($uid)) return;
        if(!session('?userid')) return;
        $ma = D('Article');
        $mu = D('User');
        $mt = D('Tags');
        $mat = D('Article_tags');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文
        // dump($tagid);
        $userid = session('userid');
        $res = $mu->getBeLike($uid,$page);

        if(!$res['count']){
            $res['articles']=0;
        }
        $this->assign('articles',$res['articles']);
        $this->assign('articlepage',intval($res['count']/$this->articleLimit));

        $this->assign('currentUserInform',$mu->getUserInformation($uid));

        $this->assign('userInform',$mu->getUserInformation($userid));

        $this->display();
    }
    public function likeBeUsers($uid,$page=1){
        if(!is_numeric($uid)) return;
        if(!session('?userid')) return;
        $ma = D('Article');
        $mu = D('User');
        $mt = D('Tags');
        $mat = D('Article_tags');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文
        // dump($tagid);
        $userid = session('userid');
        $res = $mu->getBeLike($uid,$page);

        if(!$res['count']){
            $res['articles']=0;
        }
        $this->assign('articles',$res['articles']);
        $this->assign('articlepage',intval($res['count']/$this->articleLimit));

        $this->assign('currentUserInform',$mu->getUserInformation($uid));
        $this->assign('currentpage',$page);

        $this->assign('userInform',$mu->getUserInformation($userid));

        $this->display();
    }
    public function commentout($page=1){
        if(!session('?userid')) return;
        $mu = D('User');
        $mt = D('Tags');
        $mc = D('comment');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文
        // dump($tagid);
        $userid = session('userid');
        $res = $mc->getCommentOut($userid,$page);

        if(!$res['comment']){
            $res['comment']=0;
        }
        $this->assign('comments',$res['comment']);

        //分页
        $this->assign('articlepage',intval(($res['count']-1)/$this->articleLimit)+1);
        $this->assign('currentpage',$page);

        //用户信息(其实评论页是不需要currentUserInform的,懒得改了)
        $this->assign('currentUserInform',$mu->getUserInformation($userid));
        $this->assign('userInform',$mu->getUserInformation($userid));

        $this->display();
    }
    public function commentin($page=1){
        if(!session('?userid')) return;
        $mu = D('User');
        $mt = D('Tags');
        $mc = D('comment');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文
        // dump($tagid);
        $userid = session('userid');
        $res = $mc->getCommentIn($userid,$page);

        if(!$res['comment']){
            $res['comment']=0;
        }
        $this->assign('comments',$res['comment']);
        // dump($res['comment']);
        $this->assign('page',intval($res['count']/$this->articleLimit));

        $this->assign('currentUserInform',$mu->getUserInformation($userid));

        $this->assign('userInform',$mu->getUserInformation($userid));

        $this->display();
    }

    public function search(){
        $page=I('get.page',1);
        if(!$key=I('get.key')){return;};
        $userid = session('?userid')?session('userid'):'';

        $mu = D('User');
        $mt = D('Tags');

        //发表文章标签
        $writetags = array_merge($mt->where('id>=1 AND id<=34')->select(),
            $mt->where('id>34')->order('hits desc')->limit(10)->select());
        $this->assign('writetags',$writetags);


        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        //正文列表
        $key_arr = preg_split('/\s+/',trim(preg_replace('/\s+/',' ',$key)),10);
        $res = D('article')->getArticleForSearch($key_arr,$userid,$page);

        if(!$res['articles']){
            $res['articles']=0;
        }
        $this->assign('articles',$res['articles']);
        $this->assign('key',$key);



        //用户信息
        if(session('?userid')){
            $this->assign('userInform',$mu->getUserInformation(session('userid')));
        }

        $this->display();

    }

    public function my(){
        if(!session('?userid')) return;
        $mu = D('User');
        $mt = D('Tags');
        $mc = D('comment');

        $userid = session('userid');

        //导航标签
        $navtags = $mt->order('hits desc')->limit(25)->select();
        $this->assign('navtags',$navtags);

        $imgurl = $mu->where(['id'=>$userid])->getField('imgurl');

        $this->assign('imgurl',$imgurl);
        $this->assign('userInform',$mu->getUserInformation($userid));

        $this->display();
    }
    public function pictureUpload(){
        if(!session('?userid')) E('上传失败');
        $config = [
            'maxSize'    =>    2097152,
            'rootPath'   =>    "Public/Uploads/",
            'saveName'   =>    'time',
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
        ];

        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传文件
        $info   =   $upload->uploadOne($_FILES['picture']);
        if(!$info) {// 上传错误提示错误信息
            E('上传失败');
        }else{// 上传成功
            $userid = session('userid');
            if(!M('user')->where(['id'=>$userid])->setField('imgurl','Uploads/'.$info['savepath'].$info['savename'])){
                E('数据库出错!');
            };
        }
    }

    public function ajaxCommitComment(){
        //问题：articleid如何参与自动验证？隐藏字段？
        //验证如何添加外键约束验证?

        if(!session('?userid')) return;

        $mc = D('comment');
        // $this->ajaxReturn($_POST);
        if(!$mc->create()) return;

        $articleid = I('post.articleid');
        // dump($articleid);
        if($id = $mc->add()){

            $res = $mc->getComments($articleid,session('userid'),1);
            foreach ($res['comment'] as &$value) {
                $value['time']=dateConvert('date',$value['time']);
            }
            $this->ajaxReturn($res);
        }
    }
    public function ajaxDeleteComment($commentid){
        if(!is_numeric($commentid)) return;
        if(!session('?userid')) return;
        $mc = D('comment');
        $mc->find($commentid);
        $articleid = $mc->articleid;
        $mc->delete($commentid);
        $res = $mc->getComments($articleid,session('userid'),1);
        foreach ($res['comment'] as &$value) {
            $value['time']=dateConvert('date',$value['time']);
        }
        $this->ajaxReturn($res);
    }
    public function ajaxCountComment($articleid){
        $mc = M('comment');
        $this->ajaxReturn($mc->where(['articleid'=>$articleid])->count());
    }
    public function delete($id){
        if(!session('?userid')) return;
        $ma = M('article');
        $ma->where(['id'=>$id])->delete();
        M('article_tags')->where(['articleid'=>$articleid])->delete();
        M('article_user')->where(['articleid'=>$articleid])->delete();
        return $this->redirect('story/index');
    }

    public function ajaxGetComments($articleid,$page){
        //如果有时间再加一层验证该用户userid是否喜欢该文章的安全保护

        if(!session('?userid')) return;
        $mc = D('comment');
        $res = $mc->getComments($articleid,session('userid'),$page);
        foreach ($res['comment'] as &$value) {
            $value['time']=dateConvert('date',$value['time']);
        }

        $this->ajaxReturn($res);
    }

    public function ajaxLikeRecord(){
        if(!I('get.idlike/d')||!I('get.belikeid/d')||!I('get.page/d',1)) return;
        $mau = D('article_user');
        $res = $mau->getLikeRecord(I('get.idlike/d'),I('get.belikeid/d'),I('get.page/d',1));
        foreach ($res['articles'] as &$value) {
            $value['time']=dateConvert('date',$value['time']);
        }
        if(!I('get.my',false)) {
            if (session('userid') == I('get.belikeid/d')) {
                $res['ifmyhome'] = true;
            } else {
                $res['ifmyhome'] = false;
            }
        }
        else{
            if (session('userid') == I('get.idlike/d')) {
                $res['ifmyhome'] = true;
            } else {
                $res['ifmyhome'] = false;
            }
        }
        $this->ajaxReturn($res);
    }
    public function ajaxGetTagName(){
        // if(!\think\Input::get('?tagid')) return;
        // $tagid = \think\Input::get('tagid');

        //将数组转换成字符串（json格式？）string(91) "["\u7acb\u79cb","\u5904\u6691","\u767d\u9732","\u4e2d\u79cb","\u5bd2\u9732","\u971c\u964d"]"
        return json_encode(M\Tags::select());
    }
    public function ajaxLikeArticle($articleid,$like){
        if(!is_numeric($articleid)) $ajax = false;
        if(!session('?userid')) $ajax = false;
        $userid = session('userid');
        $mau = D('ArticleUser');
        if($like=='true'){
            if($mau->like($articleid,$userid)) $ajax = true;
            else $ajax = false;
        }
        else if($like=='false'){
            if($mau->dislike($articleid,$userid)) $ajax = true;
            else $ajax = false;
        }
        $this->ajaxReturn($ajax);
    }
   
}
?>
