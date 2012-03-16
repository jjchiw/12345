<?php

Yii::import('zii.widgets.CPortlet');

class SearchUsers extends CPortlet
{
	public function init()
	{
		$this->title="Search Users";
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('searchUsers');
	}
}
?>