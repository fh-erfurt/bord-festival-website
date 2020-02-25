<?php

class ItemColor extends BaseModel
{
	const TABLENAME = '`item_colors`';

	public $schema = [
		'color'		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}