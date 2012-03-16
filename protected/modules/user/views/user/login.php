<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<?php $this->widget('application.widgets.openidProviders.openidProviders',array('options'=>array('lang'=>'en','cookie_expires' => 6*30))); ?>