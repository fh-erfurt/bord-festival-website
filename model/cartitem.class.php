<?php

class Cartitem extends BaseModel
{
	const TABLENAME = '`CARTITEMS`';

	public $schema = [
		'CARTITEMID'	=> [ 'type' => BaseModel::TYPE_INT ],
		'CARTID'		=> [ 'type' => BaseModel::TYPE_INT ],
		'TICKETID'  	=> [ 'type' => BaseModel::TYPE_INT ],
		'QUANTITY' 		=> [ 'type' => BaseModel::TYPE_INT ]
	];
}