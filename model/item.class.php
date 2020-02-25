<?php

class Item extends BaseModel
{
	const TABLENAME = '`ITEMS`';

	public $schema = [
		'itemid'		=> [ 'type' => BaseModel::TYPE_INT ],
		'name' 			=> [ 'type' => BaseModel::TYPE_STRING ],
		'description'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'type'			=> [ 'type' => BaseModel::TYPE_STRING ],
		'category'		=> [ 'type' => BaseModel::TYPE_STRING ],
		'color'			=> [ 'type' => BaseModel::TYPE_STRING ],
		'gender'		=> [ 'type' => BaseModel::TYPE_STRING ],
		'price' 		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}