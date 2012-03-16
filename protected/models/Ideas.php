<?php

class Ideas extends CActiveRecord
{

	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;
	
	var $update_time_automatically = true;
	
	/**
	 * The followings are the available columns in table 'ideas':
	 * @var integer $id
	 * @var string $idea
	 * @var string $status
	 * @var string $tags
	 * @var integer $author_id
	 * @var string $create_time
	 * @var string $update_time
	 * @var string $is_public
	 * @var string $description
	 */
	 
	  public function behaviors(){
          return array( 'CAdvancedArBehavior' => array(
            'class' => 'application.extensions.CAdvancedArBehavior'));
     }

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ideas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idea', 'required'),
			array('description', 'safe'),
			array('author_id', 'numerical', 'integerOnly'=>true),
			array('is_public', 'boolean'),
			array('idea', 'length', 'max'=>200),
			array('tags', 'length', 'max'=>255),
			array('status', 'in', 'range'=>array(1,2,3)),
			array('tags', 'match', 'pattern' => '/^[\w\s,]+$/u',
									'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
			'comments' => array(self::HAS_MANY, 'Comments', 'idea_id',
								//'condition'=>'comments.status='.Comments::STATUS_APPROVED,
								'order'=>'comments.rank DESC, comments.create_time DESC'),
			'commentCount' => array(self::STAT, 'Comments', 'idea_id',
									'condition'=>'status='.Comments::STATUS_APPROVED),
			'user_favorites' => array(self::MANY_MANY, 'Users', 'favorites_ideas(idea_id, user_id)'),
			'groups' => array(self::MANY_MANY, 'Groups', 'groups_ideas(idea_id, group_id)'),
			
			'comment_origin' => array(self::BELONGS_TO, 'Comments', 'comment_id'),
		);
	}
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'idea' => 'Idea',
			'status' => 'Status',
			'tags' => 'Tags',
			'author_id' => 'Author',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'is_public' => 'Public?',
			'description' => 'Description',
		);
	}
	
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tags::array2string(array_unique(Tags::string2array($this->tags)));
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::app()->user->id;
				$this->status = 2;
			}
			else if($this->update_time_automatically){
				$this->update_time=time();
			}
			return true;
		}
		else
			return false;
	}
	
	protected function afterSave()
	{
		parent::afterSave();
		Tags::model()->updateFrequency($this-> oldTags, $this->tags);
	}
	
	private $oldTags;

	protected function afterFind()
	{
		parent::afterFind();
		$this->oldTags=$this->tags;
	}
	
	protected function afterDelete()
	{
		parent::afterDelete();
		Comments::model()->deleteAll('idea_id='.$this->id);
		Tags::model()->updateFrequency($this->tags, '');
	}
	
	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tags::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('ideas/index', 'tag'=>$tag));
		return $links;
	}
	
	public function getUrl()
	{
		return Yii::app()->createUrl('ideas/view', array(
			'id'=>$this->id,
			'idea'=>$this->idea,
		));
	}
	
	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		// if(Yii::app()->params['commentNeedApproval'])
			// $comment->status=Comments::STATUS_PENDING;
		// else
		//All the comments are approved
		$comment->status=Comments::STATUS_APPROVED;
		$comment->idea_id=$this->id;
		return $comment->save();
	}
	
	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getGroupsNames()
	{
		$links=array();
		foreach($this->groups as $group)
			$links[]=$group->name;
			
		if(empty($links)){
			$links[] = "All";
		}
		return $links;
	}
	
	public function get_groups_data_provider()
	{

		$dataProvider=new CActiveDataProvider(	'Groups', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												)
											);
											
		$dataProvider->setData($this->groups);
											
		return $dataProvider;
	}
	

}