<?php

class Cart extends BaseModel
{
	const TABLENAME = '`CARTS`';

	public $schema = [
		'CARTID'		=> [ 'type' => BaseModel::TYPE_INT ],
		'TOTALPRICE'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'LASTUPDATED'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'CLIENTID' 		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}