<?php

Yii::import('zii.widgets.CPortlet');

class SearchIdeas extends CPortlet
{
	public function init()
	{
		$this->title="Search Ideas";
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('searchIdeas');
	}
}
?>