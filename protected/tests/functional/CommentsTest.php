<?php

class CommentsTest extends WebTestCase
{
	public $fixtures=array(
		'comments'=>'Comments',
	);

	public function testShow()
	{
		$this->open('?r=comments/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=comments/create');
	}

	public function testUpdate()
	{
		$this->open('?r=comments/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=comments/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=comments/index');
	}

	public function testAdmin()
	{
		$this->open('?r=comments/admin');
	}
}
