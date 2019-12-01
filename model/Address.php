<?php
namespace app\model;

class Address extends ModelBase
{
	protected $attributes = [
		'ADDRESSID' => null,
		'STREET' => null,
		'ZIP' => null,
		'CITY' => null,
		'COUNTRY' => null
	];

	public $name, $created;

	public function getSource()
	{
		return 'addresses';
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

	// static function findAll()
	// {
	// 	$db = $GLOBALS['database'];

	// 	$result = [];

	// 	try
	// 	{
	// 	 	$dbResult = $db->query('SELECT * FROM clients')->fetchAll();

	// 	 	foreach($dbResult as $index => $dbAccountObj)
	// 	 	{
	// 	 		$accountObj = new Account($dbAccountObj);
	// 	 		$result[] = $accountObj;
	// 	 	}
	// 	}
	// 	catch(\PDOException $e)
	// 	{
	// 		// TODO: Handle Error!!
	// 	}

	// 	return $result;
	// }



	// public function fullname()
	// {
	// 	return ($this->firstname ?? '') . ' ' . ($this->lastname ?? '');
	// }

}