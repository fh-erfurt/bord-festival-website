<?php

class Address extends BaseModel
{
	const TABLENAME = '`ADDRESSES`';

	public $schema = [
		'ADDRESSID'	=> [ 'type' => BaseModel::TYPE_INT ],
		'STREET' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'ZIP' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'CITY' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'COUNTRY' 	=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}