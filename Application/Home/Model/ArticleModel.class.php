<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ArticleModel extends RelationModel{
	protected $_link = array(
        'User'=>array(
            'mapping_type'=>self::BELONGS_TO,
			'foreign_key'=>'userid',
			'mapping_name'=>'user',
			'mapping_fields'=>'id,username,imgurl',
			'as_fields'=>'id:uid,username,imgurl'
        ),
        'Tags'=>array(
        	'mapping_type'      =>  self::MANY_TO_MANY,
		    'class_name'        =>  'Tags',
		    'mapping_name'      =>  'tags',
		    'foreign_key'       =>  'articleid',
		    'relation_foreign_key'  =>  'tagid',
		    'relation_table'    =>  'article_tags'
        )
    );

	protected $insertFields = 'text';

	protected $_validate = array(
     array('text','require','验证码必须'), 
     array('text','5,100','length',0,'length'), 
    );
	protected $_auto = array ( 
		array('text','htmlspecialchars',1,'function'),
		array('text','trim',1,'function'),
        array('time','time',1,'function'), 
        array('userid','getUserID',1,'callback')
     );
	// protected function getTime(){
	// 	return time();
	// }
	public $limit = 10;
	protected function getUserID(){
		return session('userid');
	}

	public function  getArticleForSearch($keyArr,$loginid='',$page=1){
		$startNumber = ($page-1)*$this->limit;

		$articles=array();
		foreach ($keyArr as $key) {
			$search_tag = $this->table('tags')->where(['name'=>['like',"%$key%"]])->buildSql();

			if(!$loginid){

				$articles_tag = $this->table('article_tags')->alias('at')
					->join("$search_tag t ON t.id=at.tagid")	//RIGHT的话at表中每个标签只显示一条了,应该是INNER

					->join('article a ON a.id=at.articleid')
					->join('user u ON a.userid=u.id')
					->group('a.id')		//确保每个文章只显示一遍
					->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username')
					->limit($startNumber,$this->limit)
					->select();
			}else {
				$au = $this->table('article_user')
					->where(['userid' => $loginid])->buildSql();

				$articles_tag = $this->table('article_tags')->alias('at')
					->join("$search_tag t ON t.id=at.tagid")

					->join('article a ON a.id=at.articleid')
					->join('user u ON a.userid=u.id')
					->join("$au as au ON a.id=au.articleid")
					->group('a.id')
					->order('a.time desc')
					->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username,au.userid as ulike')
					->limit($startNumber, $this->limit)
					->select();
			}

			$count = $this->table('article_tags')->alias('at')
				->join("$search_tag t ON t.id=at.tagid")	//RIGHT的话at表中每个标签只显示一条了,应该是INNER

				->join('article a ON a.id=at.articleid')
				->group('a.id')		//确保每个文章只显示一遍
				->count();

			if(!$articles){
				$articles = $articles_tag;
			}
			else{
				$articles=array_merge($articles_tag,$arr_merged);
			};
			$r = usort($articles,"sortTime");	//按照时间顺序排序

			foreach ($articles as &$value) {
				$id = $value['id'];
				$commentnum = $this->table('comment')
					->where(['articleid'=>$id])
					->count();
				$value['commentnum'] = $commentnum;
			}
			foreach ($articles as &$value) {
				$id = $value['id'];
				$article_tags = $this->alias('a')
					->join('article_tags at ON a.id=at.articleid')
					->join('tags t ON at.tagid=t.id')
					->where(['a.id'=>$id])
					->field('t.id,t.name')
					->select();
				$value['tags'] = $article_tags;
			}
			return ['articles'=>$articles,'count'=>$count];
		}
		$arr_merged = array_unique($arr_merged);
		foreach ($arr_merged as &$value) {
			$id = $value['id'];
			$commentnum = $this->table('comment')
				->where(['articleid'=>$id])
				->count();
			$value['commentnum'] = $commentnum;
		}
		foreach ($arr_merged as &$value) {
			$id = $value['id'];
			$article_tags = $this->alias('a')
				->join('article_tags at ON a.id=at.articleid')
				->join('tags t ON at.tagid=t.id')
				->where(['a.id'=>$id])
				->field('t.id,t.name')
				->select();
			$value['tags'] = $article_tags;
		}
//		dump($arr_merged);
//		return ['articles'=>$arr_merged,'count'=>$count];
	}

	public function getArticleForMain($tagid='',$loginid='',$start=1){
		$startNumber = ($start-1)*$this->limit;
		if(empty($tagid)){
			if(empty($loginid)){
				$articles = $this->alias('a')
					->join('user u ON a.userid=u.id')
					->join('article_tags at ON a.id=at.articleid')
					->join('tags t ON at.tagid=t.id')
					->group('a.id')		//因为join了article_tag会有很多条重复
					->order('a.time desc')
					->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username')
					->limit($startNumber,$this->limit)
					->select();
			}
			else{
				$au = $this->table('article_user')
					->where(['userid'=>$loginid])->buildSql();

				$articles = $this->alias('a')
					->join('user u ON a.userid=u.id')
					->join('article_tags at ON a.id=at.articleid','left')
					->join('tags t ON at.tagid=t.id')
					->join("$au as au ON a.id=au.articleid",'LEFT')
					->group('a.id')
					->order('a.time desc')
					->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username,au.userid as ulike')
					->limit($startNumber,$this->limit)
					->select();
			}
			$count = $this->count();
		}
		else{
			if(empty($loginid)){
				$articles = $this->alias('a')
						->join('user u ON a.userid=u.id')
						->join('article_tags at ON a.id=at.articleid')
						->join('tags t ON at.tagid=t.id')
						->group('a.id')
						->order('a.time desc')
						->where(['t.id'=>$tagid])
						->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username')
						->limit($startNumber,$this->limit)
						->select();
			}
			else{
				$au = $this->table('article_user')
					->where(['userid'=>$loginid])->buildSql();

				$articles = $this->alias('a')
					->join('user u ON a.userid=u.id')
					->join('article_tags at ON a.id=at.articleid')
					->join('tags t ON at.tagid=t.id')
					->join("$au as au ON a.id=au.articleid",'LEFT')
					->group('a.id')
					->order('a.time desc')
					->where(['t.id'=>$tagid])
					->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username,au.userid as ulike')
					->limit($startNumber,$this->limit)
					->select();
			}
			$count = $this->table('article_tags')->where(['tagid'=>$tagid])->count();
		}
		foreach ($articles as &$value) {
			$id = $value['id'];
			$commentnum = $this->table('comment')
				->where(['articleid'=>$id])
				->count();
			$value['commentnum'] = $commentnum;
		}
		foreach ($articles as &$value) {
				$id = $value['id'];
				$article_tags = $this->alias('a')
					->join('article_tags at ON a.id=at.articleid')
					->join('tags t ON at.tagid=t.id')
					->where(['a.id'=>$id])
					->field('t.id,t.name')
					->select();
				$value['tags'] = $article_tags;
		}
		return ['articles'=>$articles,'count'=>$count];
	}

	public function getArticleForHome($loginid,$uid,$start=1,$like=false){
		$startNumber = ($start-1)*$this->limit;
		$au = $this->table('article_user')
				->where(['userid'=>$loginid])->buildSql();
		if($like==false){
			$articles = $this->alias('a')
				->join('user u ON a.userid=u.id')
				->join('article_tags at ON a.id=at.articleid')
				->join('tags t ON at.tagid=t.id')
				->join("$au as au ON a.id=au.articleid",'LEFT')
				->group('a.id')
				->order('a.time desc')
				->where(['u.id'=>$uid])
				->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username,au.userid as ulike')
				->limit($startNumber,$this->limit)
				->select();

			$articles_count = $this->alias('a')
				->join('user u ON a.userid=u.id')
				->join("$au as au ON a.id=au.articleid",'LEFT')
				->group('a.id')
				->where(['u.id'=>$uid])
				->field('a.id')
				->select();

			$count = count($articles_count);

		}	
		else{
			$au = $this->table('article_user')
				->where(['userid'=>$uid])->buildSql();

			$articles = $this->alias('a')
				->join('user u ON a.userid=u.id')
				->join('article_tags at ON a.id=at.articleid')
				->join('tags t ON at.tagid=t.id')
				->join("$au as au ON a.id=au.articleid",'RIGHT')
				->group('a.id')
				->order('a.time desc')
				->field('a.id,a.time,a.text,u.id as uid,u.imgurl,u.username,au.userid as ulike')
				->limit($startNumber,$this->limit)
				->select();

			$articles_count = $this->alias('a')
				->join('user u ON a.userid=u.id')
				->join("$au as au ON a.id=au.articleid",'RIGHT')
				->group('a.id')
				->field('a.id')
				->select();

			//有group的语句用count就变成了计算每组的行数

			$count = count($articles_count);
		}
		foreach ($articles as &$value) {
			$id = $value['id'];
			$commentnum = $this->table('comment')
				->where(['articleid'=>$id])
				->count();
			$value['commentnum'] = $commentnum;
		}
		foreach ($articles as &$value) {
				$id = $value['id'];
				$article_tags = $this->alias('a')
					->join('article_tags at ON a.id=at.articleid')
					->join('tags t ON at.tagid=t.id')
					->where(['a.id'=>$id])
					->field('t.id,t.name')
					->select();
				$value['tags'] = $article_tags;
		}

		return ['articles'=>$articles,'count'=>$count];

	}
}
?>