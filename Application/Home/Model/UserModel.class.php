<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protected $insertFields = 'username,password,imgurl';
	protected $_validate = array(
     array('username','require','用户名必须'), 
     array('username','3,21','用户名长度3-21',0,'length'), 
     array('username','valiSignup','用户名已存在',0,'callback',self::MODEL_INSERT), 
     array('password','5,15','密码',0,'length'), 
     array('password','require','密码'), 
    );
    protected $_auto = array (
	    array('imgurl','image/default_head.jpeg'), 
		array('imgurl','htmlspecialchars',1,'function')
     );
    public $limit = 5;
    public function valiSignup($username,$password){
    	if($this->where(['username'=>$username])->find()){
    		return false;
    	} 
    	else{
    		return true;
    	}
    }
    public function valiLogin($username,$password){
    	$tuple = $this->where(['username'=>"$username"])->find();
    	if(!$tuple) return 0;	//找不到该用户名
    	if($password!=$tuple['password']) return -1;		//密码不正确
    	return $tuple['id'];
    }
	public function getUserInformation($uid){

		//该用户的故事数目
		$story = $this->table('article')->group('userid')
			->field('userid,count(*) as storynum')->buildSql();

		$res = $this->alias('u')->where("id=$uid")
			// ->join("$love as love ON u.id=love.userid",'LEFT')
			->join("$story as story ON u.id=story.userid",'LEFT')
			->find();

		//该用户发表过的文章id
		$articleids = $this->table('article')->where(['userid'=>$uid])->getField('id',true);
		if($articleids){
			$res['likenum'] = $this->table('article_user')->where(['articleid'=>['in',$articleids]])->count();
		}
		else{
			$res['likenum']=0;
		}
		return $res;
	}
	public function getUserLikes($userid,$page){
		$startNumber = ($page-1)*$this->limit;

		$story = $this->table('article')->group('userid')
			->field('userid,count(*) as storynum')->buildSql();

		$res = $this->table('article_user')->distinct(true)->alias('au')
			->where(['au.userid'=>$userid])
			->join('article a ON a.id=au.articleid')
			->join('user u ON a.userid=u.id')
			->join("$story as story ON u.id=story.userid",'LEFT')
			->limit($startNumber,$this->limit)
			->field('u.id,u.username,u.imgurl,story.storynum')
			->select();
		// dump($res);
		$res = array_unique($res);
		$count = $this->distinct(true)->table('article_user')->alias('au')
			->where(['au.userid'=>$userid])
			->join('article a ON a.id=au.articleid')
			->join('user u ON a.userid=u.id')
			->count();

		foreach ($res as &$value) {
			$articleids = $this->table('article')->where(['userid'=>$value['id']])->getField('id',true);
			if($articleids){
				$value['likenum'] = $this->table('article_user')->where(['articleid'=>['in',$articleids]])->count();
			}
			else{
				$value['likenum']=0;
			}
		}
		
		return ['articles'=>$res,'count'=>$count];
	}
	public function getBeLike($userid,$page){
		$startNumber = ($page-1)*$this->limit;
		
		//搜索我发表过的文章,根据文章id找出是否存在关注我的用户
		$res = $this->table('article')->alias('a')->where(['a.userid'=>$userid])
			->join('article_user au ON au.articleid=a.id','left')
			->join('user u ON u.id=au.userid')	//该用户(关注我的)的信息
			->field('u.id,u.username,u.imgurl,a.text,au.time,au.hasRead')
			->limit($startNumber,$this->limit)
			->select();
		$res = array_unique($res);
		$count = $this->table('article')->alias('a')->where(['a.userid'=>$userid])
			->join('article_user au ON au.articleid=a.id')
			->count();

		$newCount = $this->table('article')->alias('a')->where(['a.userid'=>$userid],['au.hasRead'=>0])
			->join('article_user au ON au.articleid=a.id','left')
			->count();

		return ['articles'=>$res,'count'=>$count,'newCount'=>$newCount];
	}
	public function signup($username,$password){
		//若找不到结果，则返回bool(false);若找到结果，则返回app\index\model\User类实例
		$username_result = $this->where("username='$username'")->find();
		if($username_result){
			return false;
		}
		$res = $this->insert([
			'username'=>"$username",
			'password'=>"$password",
			'imgurl'=>"default_head.jpeg"
		]);
		if($res){
			return true;
		}
		return false;
	}
}
?>