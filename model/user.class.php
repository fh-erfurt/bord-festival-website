<?php

class Client extends BaseModel
{
	const TABLENAME = '`CLIENTS`';

	public $schema  = [
		'clientid' 		=> [ 'type' => BaseModel::TYPE_INT ],
		'mail' 			=> [ 'type' => BaseModel::TYPE_STRING ],
		'firstname'		=> [ 'type' => BaseModel::TYPE_STRING ],
		'lastname' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'dateofbirth'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'password' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'createdat' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'updatedat' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'addressid' 	=> [ 'type' => BaseModel::TYPE_INT ]
	];
}