<?php

class Comments extends CActiveRecord
{

	const STATUS_PENDING=1;
	const STATUS_APPROVED=2;
	/**
	 * The followings are the available columns in table 'comments':
	 * @var integer $id
	 * @var string $email
	 * @var string $content
	 * @var string $status
	 * @var integer $idea_id
	 * @var string $create_time
	 */

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
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required'),
			array('content', 'length', 'max'=>200),
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
			'idea' => array(self::BELONGS_TO, 'Ideas', 'idea_id'),
			'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
			'votes' => array(self::HAS_MANY, 'Votes', 'comment_id'),
			'ideas' => array(self::HAS_MANY, 'Ideas', 'comment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'email' => 'Email',
			'content' => 'Content',
			'status' => 'Status',
			'idea_id' => 'Idea',
			'create_time' => 'Create Time',
			'rank' => 'Rank',
		);
	}
	
			/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time = time();
				if(!Yii::app()->user->isGuest){
					$this->author_id = Yii::app()->user->id;
					$user=Users::model()->findByPk($this->author_id);
					$this->email = $user->email;
				}
			}
			return true;
		}
		else
			return false;
	}
	
	/**
	 * @param Idea the idea that this comment belongs to. If null, the method
	 * will query for the idea.
	 * @return string the permalink URL for this comment
	 */
	public function getUrl($idea=null)
	{
		if($idea===null)
			$idea=$this->idea;
		return $idea->url.'#c'.$this->id;
	}
	
	/**
	 * @param integer the maximum number of comments that should be returned
	 * @return array the most recently added comments
	 */
	public function findRecentComments($limit=10)
	{
		return $this->with('idea')->findAll(array(
			'condition'=>'t.status='.self::STATUS_APPROVED,
			'order'=>'t.create_time DESC',
			'limit'=>$limit,
		));
	}
	
	/**
	 * @param integer the maximum number of comments that should be returned
	 * @return array the most recently added comments
	 */
	public function userHasAlreadyVote($comment)
	{
		$criteria=new CDbCriteria();
		
		$criteria->addCondition('t.id = '.$comment);
		$criteria->addCondition('votes.user_id = '.Yii::app()->user->id);
	
		$comment=Comments::model()->with('votes')->find($criteria);
		
		return !empty($comment);
	}
}