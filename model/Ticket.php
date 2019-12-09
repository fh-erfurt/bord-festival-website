<?php
namespace app\model;

class Ticket extends ModelBase
{
	protected $attributes = [
		'TICKETID' => null,
		'NAME' => null,
		'DESCRIPTION' => null,
		'PRICE' => null
	];

	public $name, $created;

	public function getSource()
	{
		return 'tickets';
	}

	public function getIdName()
	{
		return array_key_first($this->attributes);
	}

	public function beforeCreate()
	{
		$this->created = date('Y-m-d H:i:s');
	}

	// TODO: MOVE TO BASEMODEL
	public function __get($key)
	{
		if(isset($this->attributes[$key]))
		{
			return $this->attributes[$key];
		}
	}

	// TODO: MOVE TO BASEMODEL
	public function __set($key, $value)
	{
		if(array_key_exists($key, $this->attributes))
		{
			$this->attributes[$key] = $value;
		}
	}
}