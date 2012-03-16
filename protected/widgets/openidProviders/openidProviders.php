<?php

class openidProviders extends CWidget {

    public $options = array();

    public function run() {

	$cs = Yii::app()->clientScript;

	$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
	$baseUrl = Yii::app()->getAssetManager()->publish($dir.'/assets');

	$clientScript = Yii::app()->getClientScript();
	$clientScript->registerCoreScript('jquery');
	$clientScript->registerCssFile($baseUrl . '/css/openid.css');
	$clientScript->registerScriptFile($baseUrl . '/js/openid-jquery.js', CClientScript::POS_HEAD);
	if (isset($this->options['lang']))
	    $clientScript->registerScriptFile($baseUrl . '/js/openid-jquery-' . $this->options['lang'] . '.js', CClientScript::POS_HEAD);

	$js = "$(document).ready(function(){".PHP_EOL;;
	if(empty($this->options['img_path']))
		$this->options['img_path'] = $baseUrl.'/images/';
	if(!empty($this->options))
	{
	    foreach($this->options as $opt=>$val)
	    {
		$js.='openid.'.$opt.' = '.CJavaScript::encode($val).';'.PHP_EOL;
	    }
	}
	$js.="	openid.init('openid_identifier');".PHP_EOL;;
	$js.="})";

	$cs->registerScript('openidProviders', $js, CClientScript::POS_HEAD);

	echo $this->render('main-'.$this->options['lang']);

    }

}

?>
