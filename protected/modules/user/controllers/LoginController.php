<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					$this->redirect(Yii::app()->controller->module->returnUrl);
				}
			}
			else
			{
				if($this->validate()) {
					$this->lastViset();
					$this->redirect(Yii::app()->controller->module->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model,));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function encryptPwd($s)
	{
		$s2 = "";
		$s3 = "";

		for($i = 0; $i < strlen($s); $i++)
		{
			if($i % 3 == 0)
				$s2 = $s2 . strtoupper($s[$i]);
			else
				$s2 = $s2 . $s[$i];
		}

		for($i = 0; $i < strlen($s2); $i++)
		{
			if($i % 2 == 0)
				$s3 = $s3 . ord($s2[$i]);
			else
				$s3 = $s3 . $s2[$i];
		}
		
		return $s3;

	}
	
	private function validate(){
		$loid = Yii::app()->loid->load();
		if (!empty($_GET['openid_mode'])) {
			if ($_GET['openid_mode'] == 'cancel') {
				$err = Yii::t('core', 'Authorization cancelled');
				return false;
			} else {
				try {
					if($loid->validate())
					{
						$attrs = $loid->getAttributes();
						$pwd = $this->encryptPwd($attrs['contact/email']);
						
						$modelULogin=new UserLogin;
						$modelULogin->username = $attrs['contact/email'];
						$modelULogin->password = $pwd;
						$modelULogin->rememberMe = true;
						
						if($modelULogin->validate()) {
								$this->lastViset();
								$this->redirect(Yii::app()->controller->module->returnUrl);
						} else {
							$model=new User;
							$model->username = $attrs['contact/email'];
							$model->email = $attrs['contact/email'];
							$model->password=UserModule::encrypting($pwd);
							$model->activkey=UserModule::encrypting(microtime().$model->password);
							$model->createtime=time();
							$model->lastvisit=((Yii::app()->controller->module->autoLogin&&Yii::app()->controller->module->loginNotActiv)?time():0);
							$model->superuser=0;
							$model->status=1;
							
							if ($model->save()) {
								$profile=new Profile;
								$profile->user_id=$model->id;
								$profile->lastname = $model->username;
								$profile->firstname = $model->username;
								$profile->save();
							
								$modelULogin=new UserLogin;
								$modelULogin->username = $model->username;
								$modelULogin->password = $pwd;
								$modelULogin->rememberMe = true;
								if($modelULogin->validate()) {
									$this->lastViset();
									$this->redirect(Yii::app()->controller->module->returnUrl);
								}
							}
							
						}
						
					}
				} catch (Exception $e) {
					$err = Yii::t('core', $e->getMessage());
				}
				return false;
			}
			if(!empty($err)) echo $err;
		} else {
			if (!empty($_GET['openid_identifier'])) {
				$loid->identity = $_GET['openid_identifier']; //Setting identifier
				$loid->required = array('namePerson/friendly', 'contact/email'); //Try to get info from openid provider
				$loid->realm     = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']; 
				$loid->returnUrl = $loid->realm . $_SERVER['REQUEST_URI']; //getting return URL
				if (empty($err)) {
					try {
						$url = $loid->authUrl();
						$this->redirect($url);
						return true;
					} catch (Exception $e) {
						$err = Yii::t('core', $e->getMessage());
					}
				}
			} 
			return false;
		}
	}
	
	private function lastViset() {
		$lastVisit = User::model()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}