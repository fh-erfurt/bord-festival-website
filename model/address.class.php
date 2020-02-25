<?php

class Address extends BaseModel
{
	const TABLENAME = '`ADDRESSES`';

	public $schema = [
		'addressid'	=> [ 'type' => BaseModel::TYPE_INT ],
		'street' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'zip' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'city' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'country' 	=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}