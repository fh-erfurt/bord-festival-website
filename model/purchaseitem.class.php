<?php

class Purchaseitem extends BaseModel
{
	const TABLENAME = '`PURCHASEITEMS`';

	public $schema = [
		'PURCHASEITEMID'	=> [ 'type' => BaseModel::TYPE_INT ],
		'PURCHASEID'		=> [ 'type' => BaseModel::TYPE_INT ],
		'ITEMID'  	    	=> [ 'type' => BaseModel::TYPE_INT ],
		'QUANTITY' 		    => [ 'type' => BaseModel::TYPE_INT ],
		'PRICE'	            => [ 'type' => BaseModel::TYPE_STRING ]
	];
}