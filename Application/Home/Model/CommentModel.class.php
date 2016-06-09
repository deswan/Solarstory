<?php
namespace Home\Model;
use Think\Model;
class CommentModel extends Model{
	protected $insertFields = 'articleid,userid,text';
	protected $_auto = array ( 
		array('text','htmlspecialchars',1,'function'),
        array('time','time',1,'function'), 
        array('userid','getUserID',1,'callback')
    );
    protected $_validate = array(
	    array('text','require','验证码必须'), 
	    array('articleid','require','验证码必须'), 
	    array('userid','require','验证码必须'), 
	    array('text','5,100','length',0,'length'), 
    );
    private $limit = 8;
    private $detaillimit =10;
    public function getComments($articleid,$loginid,$page){
    	//ajax加载评论
    	$start = ($page-1)*$this->detaillimit;
    	$myu = $this->table('user')->where(['id'=>$loginid])->buildSql();
    	$comment = $this->alias('c')
	    	->where("articleid=$articleid")
	    	->join('user u ON u.id=c.userid')
	    	->join("$myu myu ON myu.id=c.userid",'LEFT')
	    	->field('c.id,text,time,u.id as uid,u.imgurl,u.username,myu.id as iflike')
	    	->order('time desc')
	    	->limit($start,$this->detaillimit)
	    	->select();
	    $count = $this->where("articleid=$articleid")->count();
	    return ['comment'=>$comment,'count'=>$count];
    }
    public function getAComment($id){
    	return $this->alias('c')
	    	->where(['c.id'=>$id])
	    	->join('user u ON u.id=c.userid')
	    	->field('c.id,text,time,u.id as uid,u.imgurl,u.username')
	    	->find();
    }
    public function getCommentOut($loginid,$page=1){
    	$startNumber = ($page-1)*$this->limit;
    	$comment =  $this->alias('c')
    		->where(['c.userid'=>$loginid])
    		->join('user myu ON myu.id=c.userid')
    		->join('article a ON a.id = c.articleid')
    		->join('user tou ON tou.id=a.userid')
    		->order('c.time desc')
    		->field('c.id,c.text as commenttext,c.time,myu.id as uid,myu.imgurl,myu.username,
    			tou.username as tousername, a.id as aid,a.text as articletext')
    		->limit($startNumber,$this->limit)
    		->select();
    	$count = $this->alias('c')
    		->where(['userid'=>$loginid])
    		->count();
    	return ['comment'=>$comment,'count'=>$count];
    }
    public function getCommentIn($loginid,$page=1){
    	// dump($loginid);
    	$startNumber = ($page-1)*$this->limit;
    	$a = $this->table('article')
    		->where(['userid'=>$loginid])
    		->buildSql();
    	$comment =  $this->alias('c')
    		// ->where(['c.userid'=>$loginid])
    		->join("$a a ON a.id = c.articleid")
    		->join('user u ON u.id=c.userid')
    		->order('c.time desc')
    		->field('c.id,c.text as commenttext,c.time,u.id as uid,u.imgurl,u.username,a.id as aid,a.text as articletext')
    		->limit($startNumber,$this->limit)
    		->select();
    	$count = $this->alias('c')
    		->where(['userid'=>$loginid])
    		->count();
    	return ['comment'=>$comment,'count'=>$count];
    }

    protected function getUserID(){
		return session('userid');
	}
}
?>