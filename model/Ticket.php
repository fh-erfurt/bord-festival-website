<?php

class Ticket extends BaseModel
{
	const TABLENAME = '`TICKETS`';

	public $schema = [
		'TICKETID'		=> [ 'type' => BaseModel::TYPE_INT ],
		'NAME' 			=> [ 'type' => BaseModel::TYPE_STRING ],
		'DESCRIPTION'	=> [ 'type' => BaseModel::TYPE_STRING ],
		'PRICE' 		=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}