<?php
namespace Home\Model;
use Think\Model\RelationModel;
class TagsModel extends RelationModel{
	protected $insertFields = ['name'];
	protected $_link = array(
        'Article'=>array(
        	'mapping_type'      =>  self::MANY_TO_MANY,
		    'class_name'        =>  'Article',
		    'mapping_name'      =>  'article',
		    'foreign_key'       =>  'tagid',
		    'relation_foreign_key'  =>  'articleid',
		    'relation_table'    =>  'article_tags'
        )
    );
	public function newArticleTags($tagnames){
		$tagsid = array();
		foreach ($tagnames as $tagname) {
			$result = $this->where(['name'=>$tagname])->find();
			if($result){
				$this->where(['name'=>$tagname])->setInc('hits',1);
				$tagsid[]=$result['id'];
			}else{
				$tagsid[]=$this->add(['name'=>$tagname,'hits'=>1]);
			}
		}
		return $tagsid;
	}
}
?>