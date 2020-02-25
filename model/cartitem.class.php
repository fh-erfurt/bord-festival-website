<?php

class Cartitem extends BaseModel
{
	const TABLENAME = '`CARTITEMS`';

	public $schema = [
		'cartitemid'	=> [ 'type' => BaseModel::TYPE_INT ],
		'cartid'		=> [ 'type' => BaseModel::TYPE_INT ],
		'itemid'  		=> [ 'type' => BaseModel::TYPE_INT ],
		'quantity' 		=> [ 'type' => BaseModel::TYPE_INT ],
	];
}