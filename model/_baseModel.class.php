<?php

abstract class BaseModel
{
	const TYPE_INT = 'int';
	const TYPE_FLOAT = 'float';
	const TYPE_STRING = 'string';
	
	protected $schema = [];
	protected $data = [];
	 
	
	public function __construct($params)
	{
		foreach($this->schema as $key => $value)
		{
			if(isset($params[$key]))
			{
				$this->{$key} = $params[$key];
			}
			else
			{
				$this->{$key} = null;
			}
		}
	}
	
	public function __get($key)
	{
		if(array_key_exists($key, $this->data))
		{
			return $this->data[$key];
		}
		
		//throw new \Exception('You can\'t access property "'.$key.'" for the class "'.get_called_class());
	}
	  
	public function __set($key, $value)
	{
		if(array_key_exists($key, $this->schema))
		{
			$this->data[$key] = $value;
			return;
		}
		
		throw new \Exception('You can\'t write property "'.$key.'" for the class "'.get_called_class());
	}
	
	public function validate(&$errors = null)
	{
		foreach ($this->schema as $key => $schemaOptions)
		{
			if(isset($this->data[$key]) && is_array($schemaOptions))
			{
				$valueErrors = $this->validateValue($key, $this->data[$key], $schemaOptions);
				
				if($valueErrors !== true)
				{
					array_push($errors, ...$valueErrors);
				}
			}
		}
		
		if(count($errors) === 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	protected function validateValue($attribute, &$value, &$schemaOptions)
	{
		$type = $schemaOptions['type'];
		$errors = [];
		
		switch($type)
		{
			case BaseModel::TYPE_INT:
			break;
			case BaseModel::TYPE_FLOAT:
			break;
			case BaseModel::TYPE_STRING:
			{
				if(isset($schemaOptions['min']) && mb_strlen($value) < $schemaOptions['min'])
				{
					$errors[] = $attribute.': String needs minimum '.$schemaOptions['min'].' characters!';
				}
				if(isset($schemaOptions['max']) && mb_strlen($value) < $schemaOptions['max'])
				{
					$errors[] = $attribute.': String can have maximum '.$schemaOptions['max'].' characters!';
				}
			}
			break;
		}
		
		return count($errors) > 0 ? $errors : true;
	}
	  
	
    public static function tablename()
    {
        $class = get_called_class();
        if(defined($class.'::TABLENAME'))
        {
            return $class::TABLENAME;
        }
        return null;
	}
	
	public function save(&$errors = null)
	{
		$id = array_values($this->data)[0];
		
		if($id === null)
		{
			$this->insert($errors);
		}
		else
		{
			$this->update($errors);
		}
	}
	
	
	protected function insert(&$errors)
	{
		$db = $GLOBALS['database'];
		$idkey = array_key_first($this->schema);
		
		try
		{
			$sql = 'INSERT INTO '.self::tablename().' (';
			$valueString = ' VALUES (';
			
			foreach($this->schema as $key => $schemaOptions)
			{
				$sql .= '`'.$key.'`,';
				
				if($this->data[$key] === null)
				{
					$valueString .= 'NULL,';
				}
				else
				{
					$valueString .= $db->quote($this->data[$key]).',';
				}
			}
			
			$sql = trim($sql, ',');
			$valueString = trim($valueString, ',');
			$sql .= ')'.$valueString.');';
			
			$statement = $db->prepare($sql);
			$statement->execute();

			// fill the id
			$this->schema[$idkey] = $db->lastInsertId();
			
			return true;
		}
		catch(\PDOException $e)
		{
			$errors[] = 'Error inserting '.get_called_class();
		}
		
		return false;
	}
	
	protected function update(&$errors)
	{
		$db = $GLOBALS['database'];
		
		try
		{
			$sql = 'UPDATE '.self::tablename().' SET ';
			
			foreach($this->schema as $key => $schemaOptions)
			{				
				if($this->data[$key] !== null)
				{
					$sql .= $key.' = '.$db->quote($this->data[$key]).',';
				}
			}
			
			$sql = trim($sql, ',');

			$idfield = array_key_first($this->schema);
			
			$id = array_values($this->data)[0];
			$sql .= ' WHERE '.$idfield.' = '.$id;
			
			$statement = $db->prepare($sql);
			$statement->execute();
			
			return true;
		}
		catch(\PDOException $e)
		{
			$errors[] = 'Error updating '.get_called_class();
		}
		
		return false;
	}
	
	public function delete($where = '', &$errors = null)
	{
		$db = $GLOBALS['database'];
		
		try
		{
			if(empty($where))
			{
				$idfield = array_key_first($this->schema);
				$id = array_values($this->data)[0];
				$sql = 'DELETE FROM '.self::tablename().' WHERE '.$idfield.' = '.$id;
				$statement = $db->prepare($sql);
				$statement->execute();
			}
			else
			{				
				$sql = 'DELETE FROM '.self::tablename().' WHERE '.$where;
				$statement = $db->prepare($sql);
				$statement->execute();
			}
			
			return true;
		}
		catch(\PDOException $e)
		{
			$errors[] = 'Error deleting '.get_called_class();
		}
		
		return false;		
	}

    public static function find($where = '', $debug = false)
    {
        $db  = $GLOBALS['database'];
		$result = null;
		
        try
        {
            $sql = 'SELECT * FROM ' . self::tablename();
                
            if(!empty($where))
            {
				$sql .= ' WHERE ' . $where .  ';';
			}

			if($debug)
			{
				die($sql.'<br>');

			}
			$statement = $db->prepare($sql);
			$statement->execute();
			
            $result = $statement->fetchAll();
        }
        catch(\PDOException $e)
        {
			$errors[] = 'Error finding '.get_called_class();
		}

        return $result;
	}
	/*
	public function findFirst($where = '')
	{
        $db  = $GLOBALS['database'];
        $result = null;
		$model = new static();

        try
        {                
            if(!empty($where))
            {
				$sql = 'SELECT * FROM ' . self::tablename();
				$sql .= ' WHERE ' . $where .  'LIMIT 1;';
			}
			
			$stmt = $db->prepare($sql);
			$result = $stmt->fetchObject(get_class($model));
        }
        catch(\PDOException $e)
        {
            die('Select statment failed: ' . $e->getMessage());
		}

		return $result;
	}
	*/

    public static function count($where = '')
    {
        $db  = $GLOBALS['database'];
        $result = null;

        try
        {
            $sql = 'SELECT COUNT(*) FROM ' . self::tablename();
                
            if(!empty($where))
            {
				$sql .= ' WHERE ' . $where .  ';';
			}

			$statement = $db->prepare($sql);
			$statement->execute();

            $result = $statement->fetchColumn();
        }
        catch(\PDOException $e)
        {
			$errors[] = 'Error counting '.get_called_class();
		}

        return $result;
    }
}