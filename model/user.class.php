<?php

class Client extends BaseModel
{
	const TABLENAME = '`CLIENTS`';

	public $schema  = [
		'CLIENTID' 		=> [ 'type' => BaseModel::TYPE_INT ],
		'MAIL' 			=> [ 'type' => BaseModel::TYPE_STRING ],
		'FIRSTNAME'		=> [ 'type' => BaseModel::TYPE_STRING ],
		'LASTNAME' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'DATEOFBIRTH'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'PASSWORD' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'CREATEDAT' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'UPDATEDAT' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'ADDRESSID' 	=> [ 'type' => BaseModel::TYPE_INT ]
	];
}