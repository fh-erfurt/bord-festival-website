<?php

class Newsletter extends BaseModel
{
	const TABLENAME = '`NEWSLETTER`';

	public $schema = [
        'newsletterid'  => BaseModel::TYPE_STRING,
        'mail'          => BaseModel::TYPE_STRING,
        'createdat'     => BaseModel::TYPE_STRING
    ];  
}