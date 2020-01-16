<?php

class Item extends BaseModel
{
	const TABLENAME = '`ITEMS`';

	public $schema = [
		'ITEMID'		=> [ 'type' => BaseModel::TYPE_INT ],
		'NAME' 			=> [ 'type' => BaseModel::TYPE_STRING ],
		'DESCRIPTION'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'TYPE'			=> [ 'type' => BaseModel::TYPE_STRING ],
		'CATEGORY'		=> [ 'type' => BaseModel::TYPE_STRING ],
		'COLOR'			=> [ 'type' => BaseModel::TYPE_STRING ],
		'GENDER'		=> [ 'type' => BaseModel::TYPE_STRING ],
		'PRICE' 		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}