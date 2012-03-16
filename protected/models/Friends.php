<?php

class Friends extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Friends':
	 * @var integer $user_id
	 * @var integer $friend_id
	 * @var integer $group_id
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
		return 'friends';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
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
			'groups' => array(self::MANY_MANY, 'Groups', 'friends_groups(friend_id, group_id)'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'friend' => array(self::BELONGS_TO, 'Users', 'friend_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'friend_id' => 'Friend',
			'group_id' => 'Group',
		);
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				if(!Yii::app()->user->isGuest){
					if(!$this->areFriends(Yii::app()->user->id, $this->friend_id))
					{
						$this->create_time = time();
						$this->user_id = Yii::app()->user->id;
						return true;
					}
				}
			}
			return true;
		}
		return false;
	}
	
	public function areFriends($user_id, $friend_id)
	{
		$criteria=new CDbCriteria;
		$criteria->select='user_id';  // only select the 'title' column
		$criteria->condition='user_id=:user_id AND friend_id=:friend_id';
		$criteria->params=array(':user_id'=>$user_id, ':friend_id'=>$friend_id);
		$friend=Friends::model()->exists($criteria); // $params is not needed
		
		return $friend;
	}
	
	public function areFriendsByFriendName($user_id, $friend_name)
	{
		$friend_id = Users::model()->find('username=:username', array(':username'=>$friend_name))->id;
		return Friends::areFriends($user_id, $friend_id);
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