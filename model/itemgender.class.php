<?php

class ItemGender extends BaseModel
{
	const TABLENAME = '`item_gender`';

	public $schema = [
		'GENDER'		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}