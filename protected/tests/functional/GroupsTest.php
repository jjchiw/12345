<?php

class GroupsTest extends WebTestCase
{
	public $fixtures=array(
		'groups'=>'Groups',
	);

	public function testShow()
	{
		$this->open('?r=groups/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=groups/create');
	}

	public function testUpdate()
	{
		$this->open('?r=groups/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=groups/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=groups/index');
	}

	public function testAdmin()
	{
		$this->open('?r=groups/admin');
	}
}
