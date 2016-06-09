<?php
namespace Home\Model;
use Think\Model;
class ArticleTagsModel extends Model{
	protected $insertFields = 'articleid,tagid';
	public function inserta($articleid,$arr_tagsid){
		foreach ($arr_tagsid as $tagid) {
			$data['articleid']=$articleid;
			$data['tagid']=$tagid;
			$this->add($data);
		}
	}
	public function get($articleid){
		
	}
}
?>