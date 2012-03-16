<?php

class Users extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $password
	 * @var string $email
	 * @var string $user
	 * @var string $salt
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, email, username, salt', 'required'),
			array('password, email, username, salt', 'length', 'max'=>45),
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
			'ideas' => array(self::HAS_MANY, 'Ideas', 'author_id'),
			'friends' => array(self::HAS_MANY, 'Friends', 'user_id'),
			'groups' => array(self::HAS_MANY, 'Groups', 'user_id'),
			'favorites_ideas' => array(self::MANY_MANY, 'Ideas', 'favorites_ideas(user_id, idea_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'password' => 'Password',
			'email' => 'Email',
			'username' => 'User Name',
			'salt' => 'Salt',
		);
	}
	
	public function getUrl($user)
	{
		return Yii::app()->createUrl('ideas/user', array(
			'user'=>$user,
		));
	}
	
	public function isIdeaFavorite($user_id, $idea_id){
	
		$criteria=new CDbCriteria;
		$criteria->select='t.id';  // only select the 'title' column
		$criteria->condition='t.id=:id AND favorites_ideas_favorites_ideas.idea_id=:idea_id';
		$criteria->params=array(':id'=>$user_id, ':idea_id'=>$idea_id);
		$criteria->with=array('favorites_ideas');
		$user = Users::model()->find($criteria);
		
		return !empty($user);

	
	}
	
	public function findByName($username){
	
		$criteria=new CDbCriteria;
		$criteria->select='t.id';  // only select the 'title' column
		$criteria->condition='t.username=:username';
		$criteria->params=array(':username'=>$username);
		return Users::model()->find($criteria);
	}
}