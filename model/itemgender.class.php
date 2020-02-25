<?php

class ItemGender extends BaseModel
{
	const TABLENAME = '`item_gender`';

	public $schema = [
		'gender'		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}