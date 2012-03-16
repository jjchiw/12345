<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout="application.views.layouts.column2";

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
					'actions'=>array('*'),
					'users'=>array('*'),
			),
	
		);
	}
	
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = $this->loadUser();
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('profile','id'=>$model->id));
			}
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	// public function actionChangepassword() {
		// $form = new UserChangePassword;
		// if (Yii::app()->user->id) {
			// if(isset($_POST['UserChangePassword'])) {
					// $form->attributes=$_POST['UserChangePassword'];
					// if($form->validate()) {
						// $new_password = $this->loadUser();
						// $new_password->password = UserModule::encrypting($form->password);
						// $new_password->activkey=UserModule::encrypting(microtime().$form->password);
						// $new_password->save();
						// Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						// $this->redirect(array("profile"));
					// }
			// } 
			// $this->render('changepassword',array('form'=>$form));
	    // }
	// }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=User::model()->findbyPk(Yii::app()->user->id);
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}

}