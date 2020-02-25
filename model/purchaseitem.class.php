<?php

class Purchaseitem extends BaseModel
{
	const TABLENAME = '`PURCHASEITEMS`';

	public $schema = [
		'purchaseitemid'	=> [ 'type' => BaseModel::TYPE_INT ],
		'purchaseid'		=> [ 'type' => BaseModel::TYPE_INT ],
		'itemid'  	    	=> [ 'type' => BaseModel::TYPE_INT ],
		'quantity' 		    => [ 'type' => BaseModel::TYPE_INT ],
		'price'	            => [ 'type' => BaseModel::TYPE_STRING ]
	];
}