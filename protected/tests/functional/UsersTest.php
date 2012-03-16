<?php

class UsersTest extends WebTestCase
{
	public $fixtures=array(
		'users'=>'Users',
	);

	public function testShow()
	{
		$this->open('?r=users/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=users/create');
	}

	public function testUpdate()
	{
		$this->open('?r=users/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=users/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=users/index');
	}

	public function testAdmin()
	{
		$this->open('?r=users/admin');
	}
}
