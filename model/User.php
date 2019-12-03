<?php
namespace app\model;

class Client extends ModelBase
{
	protected $attributes = [
		'CLIENTID' => null,
		'MAIL' => null,
		'FIRSTNAME' => null,
		'LASTNAME' => null,
		'DATEOFBIRTH' => null,
		'PASSWORD' => null,
		'CREATEDAT' => null,
		'UPDATEDAT' => null,
		'ADDRESSID' => null
	];

	public $name, $created;

	public function getSource()
	{
		return 'clients';
	}

	public function beforeCreate()
	{
		$this->created = date('Y-m-d H:i:s');
	}

	// TODO: MOVE TO BASEMODEL
	// function __construct($dbData)
	// {
	// 	foreach ($this->attributes as $key => $value)
	// 	{
	// 		if(isset($dbData[$key]))
	// 		{
	// 			$this->attributes[$key] = $dbData[$key];
	// 		}
	// 	}
	// }

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