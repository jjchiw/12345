<?php

class UserController extends Controller
{
	const PAGE_SIZE=10;
	

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('authenticate', 'login'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'actions'=>array('index'),
				'users'=>array('*'),
			),
		);
	}	
	
	public function actionLogin()
	{       
		// display the login form
		$this->render('login',array());
	}
	
	public function actionAuthenticate ()
	{
	   $loid = Yii::app()->loid->load();
		if (!empty($_GET['openid_mode'])) {
			if ($_GET['openid_mode'] == 'cancel') {
				$err = Yii::t('core', 'Authorization cancelled');
			} else {
				try {
					echo $loid->validate() ? 'Logged in.' : 'Failed';
				} catch (Exception $e) {
					$err = Yii::t('core', $e->getMessage());
				}
			}
			if(!empty($err)) echo $err;
		} else {
			$loid->identity = $_GET['openid_identifier']; //Setting identifier
			$loid->required = array('namePerson/friendly', 'contact/email'); //Try to get info from openid provider
			$loid->realm     = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']; 
			$loid->returnUrl = $loid->realm . $_SERVER['REQUEST_URI']; //getting return URL
			if (empty($err)) {
				try {
					$url = $loid->authUrl();
					$this->redirect($url);
				} catch (Exception $e) {
					$err = Yii::t('core', $e->getMessage());
				}
			}
		}

	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_pase_size,
			),
		));

		$this->render('index',array(
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
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}
