<?php

class Purchase extends BaseModel
{
	const TABLENAME = '`PURCHASES`';

	public $schema = [
		'PURCHASEID'	=> [ 'type' => BaseModel::TYPE_INT ],
		'PURCHASEDAT'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'CLIENTID' 		=> [ 'type' => BaseModel::TYPE_INT ]
	];
}