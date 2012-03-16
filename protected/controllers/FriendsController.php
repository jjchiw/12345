<?php

class FriendsController extends Controller
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
	 * Add a friend to the user logged in
	 */
	public function actionAdd(){
		if(isset($_GET['friend']))
		{
			$friend = new Friends;
			$friend->friend_id=Users::model()->find('username=:username', array(':username'=>$_GET['friend']))->id;
			$friend_username = $_GET['friend'];
			if($friend->save())
			{
				Yii::app()->user->setFlash('friendAdded',"$friend_username, is your friend.");
			}
			else
			{
				Yii::app()->user->setFlash('friendAdded',"$friend_username is your friend.");
			}
			$this->redirect(array('ideas/user', 'user'=>$_GET['friend']));
			return;
		}
		$this->redirect(array('/'));
		
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		if(isset($_POST['Comments']))
		{
			$model->attributes=$_POST['Comments'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Remove a friend to the user logged in
	 */
	public function actionRemove(){
		if(isset($_GET['friend']))
		{
			$friend_id=Users::model()->find('username=:username', array(':username'=>$_GET['friend']))->id;
			$friend_username = $_GET['friend'];
			
			if($this->deleteAll(Yii::app()->user->id, $friend_id)){
				Yii::app()->user->setFlash('friendRemoved',"$friend_username, is not your friend anymore.");
			}
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('myFriends'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
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
	 * Lists all models.
	 */
	public function actionMyFriends()
	{
		
		$criteria=new CDbCriteria(array(
										'order'=>'create_time DESC',
										'with'=>array('friend'=>array('select'=>'username')),
		));
		
		$criteria->addCondition('t.user_id = ' .Yii::app()->user->id);
	
		$dataProvider=new CActiveDataProvider(	'Friends', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);

		$this->render('my_friends',array('dataProvider'=>$dataProvider));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$dataProvider=new CActiveDataProvider('Comments', array(
			'pagination'=>array(
				'pageSize'=>self::PAGE_SIZE,
			),
		));

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel($user_id, $friend_id)
	{
		if($this->_model===null)
		{
			$criteria=new CDbCriteria;
			$criteria->condition='user_id=:user_id AND friend_id=:friend_id';
			$criteria->params=array(':user_id'=>$user_id, ':friend_id'=>$friend_id);
			$this->_model=Friends::model()->find($criteria); // $params is not needed
		}
		return $this->_model;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function deleteAll($user_id, $friend_id)
	{
		if($this->_model===null)
		{
			$criteria=new CDbCriteria;
			$criteria->condition='user_id=:user_id AND friend_id=:friend_id';
			$criteria->params=array(':user_id'=>$user_id, ':friend_id'=>$friend_id);
			return Friends::model()->deleteAll($criteria); // $params is not needed
		}
		return null;

	}
}
