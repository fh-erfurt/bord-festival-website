<?php

class Purchase extends BaseModel
{
	const TABLENAME = '`PURCHASES`';

	public $schema = [
		'purchaseid'	=> [ 'type' => BaseModel::TYPE_INT ],
		'purchasedat'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'clientid' 		=> [ 'type' => BaseModel::TYPE_INT ]
	];
}