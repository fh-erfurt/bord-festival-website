<?php

class ItemCategory extends BaseModel
{
	const TABLENAME = '`item_categories`';

	public $schema = [
		'CATEGORY'		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}