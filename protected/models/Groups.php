<?php

class Groups extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Groups':
	 * @var integer $id
	 * @var integer $user_id
	 * @var string $name
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
		return 'groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>45),
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
			'friends' => array(self::MANY_MANY, 'Friends',
                'friends_groups(group_id, friend_id)'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'ideas' => array(self::MANY_MANY, 'Ideas', 'groups_ideas(group_id, idea_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'user_id' => 'User',
			'name' => 'Name',
		);
	}
	
	public static function loggedUserGroupsFriends($friend_id)
	{
		$friend = Friends::model()->findByPk($friend_id);
		
		$groups = self::model()->findAll(array(
											'condition'=>'t.user_id=:user_id',
											'params'=>array(':user_id'=>Yii::app()->user->id),
											));
		
		$groups_friends = self::rem_array($groups, $friend->groups);
		
		
		
		return $groups_friends;
	}
	
	public static function loggedUserGroups()
	{
		
		return  self::model()->findAll(array(
											'condition'=>'t.user_id=:user_id',
											'params'=>array(':user_id'=>Yii::app()->user->id),
											));
	}
	
	public static function loggedUserGroupsIdeas($idea_id)
	{
	
		$idea = Ideas::model()->findByPk($idea_id);
		
		$groups = self::model()->findAll(array(
											'condition'=>'t.user_id=:user_id',
											'params'=>array(':user_id'=>Yii::app()->user->id),
											));
		
		return self::rem_array($groups, $idea->groups);
	}
	
	private static function rem_array($array1,$array2)
	{
		$groups_friends = array();
		foreach ($array1 as $key1 => $value1) 
		{
			$add = true;
			foreach ($array2 as $key2 => $value2) 
			{
				if ($value1->id == $value2->id) 
				{
					$add = false;
					break;
				}	
			}
			if($add)
			{
				$groups_friends[] = $value1;
			}
			
		}
		return $groups_friends;
	}
}