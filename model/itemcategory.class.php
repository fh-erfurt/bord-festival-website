<?php

class ItemCategory extends BaseModel
{
	const TABLENAME = '`item_categories`';

	public $schema = [
		'category'		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}