<?php

class CommentsController extends Controller
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
			array(	'allow', // allow all users to perform 'list' and 'show' actions
					'actions'=>array('index', 'view'),
					'users'=>array('*'),
			),
		
			array(	'allow', // allow authenticated users to perform any action
					'users'=>array('@'),
			),
			
			array(	'deny', // deny all users
					'users'=>array('*'),
			),
		);
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Comments;
		if(isset($_POST['Comments']))
		{
			$model->attributes=$_POST['Comments'];
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Comments', array(
			'pagination'=>array(
				'pageSize'=>self::PAGE_SIZE,
			),
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
	 * Updates votes comments
	 * If update is successful, the browser will be redirected to the 'view' idea page.
	 */
	public function actionVote()
	{
		if(isset($_GET['comment']) && isset($_GET['vote']))
		{
			$comment=Comments::model()->findByPk($_GET['comment']);
			if(!Comments::userHasAlreadyVote($_GET['comment']))
			{
				$comment->rank+=$_GET['vote'];
				$comment->save();// save the change to database
				
				$vote=new Votes;
				$vote->comment_id = $comment->id;
				$vote->user_id = Yii::app()->user->id;
				$vote->save();
				
				Yii::app()->user->setFlash('voteSubmitted','Vote counts');
			}
			else
			{
				Yii::app()->user->setFlash('voteSubmitted','You have already vote for this comment');
			}
			$this->redirect(array('ideas/view','id'=>$comment->idea_id));
			return;
		}
		$this->redirect(array('/'));
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
				$this->_model=Comments::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}
