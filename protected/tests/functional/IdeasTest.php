<?php

class IdeasTest extends WebTestCase
{
	public $fixtures=array(
		'ideases'=>'Ideas',
	);

	public function testShow()
	{
		$this->open('?r=ideas/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=ideas/create');
	}

	public function testUpdate()
	{
		$this->open('?r=ideas/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=ideas/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=ideas/index');
	}

	public function testAdmin()
	{
		$this->open('?r=ideas/admin');
	}
}
