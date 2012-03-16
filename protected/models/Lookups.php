<?php

class Lookups extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'lookups':
	 * @var integer $id
	 * @var string $name
	 * @var string $code
	 * @var string $type
	 * @var integer $position
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lookups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, type, position', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('name, code, type', 'length', 'max'=>45),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'code' => 'Code',
			'type' => 'Type',
			'position' => 'Position',
		);
	}
	
	private static $items=array();
	
	public static function items($type)
	{
		if(!isset(self::$items[$type]))
			self::loadItems($type);
		return self::$items[$type];
	}
	
	public static function item($type,$code)
	{
		if(!isset(self::$items[$type]))
			self::loadItems($type);
		return isset(self::$items[$type][$code]) ? self::$items[$type][$code] : false;
	}
	
	private static function loadItems($type)
	{
		self::$items[$type]=array();
		$models=self::model()->findAll(array(
											'condition'=>'type=:type',
											'params'=>array(':type'=>$type),
											'order'=>'position',
											));
		
		foreach($models as $model)
			self::$items[$type][$model->code]=$model->name;
	}
}