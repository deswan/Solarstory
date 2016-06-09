<?php
namespace Home\Model;
use Think\Model;
class ArticleUserModel extends Model{
	protected $_auto = array (
		array('hasRead',0)
	);
	public function like($articleid,$userid){
		$data['time']=time();
		$data['articleid']=$articleid;
		$data['userid']=$userid;
		if($this->where($data)->find())
			return false;
		if($this->add($data))
			return true;
		return false;
	}
	public function dislike($articleid,$userid){
		$data['articleid']=$articleid;
		$data['userid']=$userid;
		if(!$this->where($data)->find())
			return false;
		if($this->where($data)->delete())
			return true;
	}
	public function getLikeRecord($idlike,$likeid,$page){
		$startNumber = ($page-1)*5;
		$belike = $this->table('article')->where(['userid'=>$likeid])->buildSql();
		$res = $this->distinct(true)->alias('au')->where(['au.userid'=>$idlike])
			->join("$belike a ON au.articleid=a.id")
			->limit($startNumber,5)
			->field('au.time,a.id,a.text')
			->select();
		$count = $this->distinct(true)->alias('au')->where(['au.userid'=>$idlike])
			->join("$belike a ON au.articleid=a.id")
			->count();
		return ['articles'=>$res,'count'=>$count];
	}
	
}
?>