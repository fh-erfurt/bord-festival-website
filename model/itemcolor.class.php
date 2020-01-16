<?php

class ItemColor extends BaseModel
{
	const TABLENAME = '`item_colors`';

	public $schema = [
		'COLOR'		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}