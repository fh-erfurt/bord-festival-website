<?php

class Cart extends BaseModel
{
	const TABLENAME = '`CARTS`';

	public $schema = [
		'cartid'		=> [ 'type' => BaseModel::TYPE_INT ],
		'totalprice'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'totalcount'	=> [ 'type' => BaseModel::TYPE_INT ],
		'lastupdated'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'clientid' 		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}