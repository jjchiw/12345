<?php

class GroupsController extends Controller
{
	const PAGE_SIZE=10;
	public $layout="column2";

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(	'allow', // allow authenticated users to perform any action
					'users'=>array('@'),
			),
			
			array(	'deny', // deny all users
					'users'=>array('*'),
			),
		);
	}
	
	/**
	* List all the groups of the user
	*/
	public function actionUser()
	{
		$criteria=new CDbCriteria(array('with'=>array('user'),
		));
		
		if(isset($_GET['user'])){
			$criteria->addCondition('user.username = \'' . $_GET['user'] . '\'');
		}
	
		$dataProvider=new CActiveDataProvider(	'Groups', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);

		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$group = $this->loadModel();
											
		$dataProvider=new CActiveDataProvider(	'Friends', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												)
											);
											
		$dataProvider->setData($group->friends);
		
		$dataProviderIdeas=new CActiveDataProvider(	'Ideas', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												)
											);
											
		$dataProviderIdeas->setData($group->ideas);
											
		$this->render('view',array(
			'model'=>$group,
			'dataProvider'=>$dataProvider,
			'dataProviderIdeas'=>$dataProviderIdeas,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Groups;
		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
			$model->user_id = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * Remove Friend from User Groups
	 */
	public function actionRemoveFriend()
	{
		if(isset($_GET['group']) && isset($_GET['friend']))
		{
			$group = Groups::model()->findByPk($_GET['group']);
			if($group->user->id == Yii::app()->user->id)
			{
				$friend = Friends::model()->findByPk($_GET['friend']);
				
				$friend->groups = ArrayUtils::rem_array_obj_obj($friend->groups,$group);
				
				$friend->save();
			}
			
		
		}
		$this->redirect(array('friends/myFriends'));
	}
	
	/**
	 * Remove Idea from User Groups
	 */
	public function actionRemoveIdea()
	{
		if(isset($_GET['group']) && isset($_GET['idea']))
		{
			$group = Groups::model()->findByPk($_GET['group']);
			if($group->user->id == Yii::app()->user->id)
			{
				$idea = Ideas::model()->findByPk($_GET['idea']);
				
				$idea->groups = ArrayUtils::rem_array_obj_obj($idea->groups,$group);
				
				$idea->save();
			}
			
		
		}
		$this->redirect(array('ideas/update/', 'id'=>$_GET['idea']));
	}
	
	/**
	 * Add Friend to groups selected
	 */
	public function actionAddFriends()
	{
		if(isset($_GET['friend']))
		{
			$friend_id = $_GET['friend'];
			$model = $this->loadFriendModel(Yii::app()->user->id, $friend_id);
			if(isset($_POST['Friends']))
			{
				$model->groups = array_merge($model->groups, array_values($_POST['Friends']['Groups']));
				$model->save();
			}
		}
		
		$this->redirect(array('friends/myFriends'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array('with'=>array('user'),
		));
		
		$criteria->addCondition('user.username = \'' . Yii::app()->user->name . '\'');
	
		$dataProvider=new CActiveDataProvider('Groups', array(
			'pagination'=>array(
				'pageSize'=>self::PAGE_SIZE,
			),
			'criteria' => $criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$criteria=new CDbCriteria(array('with'=>array('user'),
		));
		
		$criteria->addCondition('user.username = \'' . Yii::app()->user->name . '\'');
	
		$dataProvider=new CActiveDataProvider('Groups', array(
			'pagination'=>array(
				'pageSize'=>self::PAGE_SIZE,
			),
			'criteria' => $criteria,
		));

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Groups::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadFriendModel($user_id, $friend_id)
	{
		if($this->_model===null)
		{
			$criteria=new CDbCriteria;
			$criteria->condition='user_id=:user_id AND friend_id=:friend_id';
			$criteria->params=array(':user_id'=>$user_id, ':friend_id'=>$friend_id);
			return Friends::model()->find($criteria); // $params is not needed
		}
		return null;
	}
	
}
