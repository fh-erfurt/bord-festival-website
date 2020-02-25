<?php

class Support_mail extends BaseModel
{
	const TABLENAME = '`SUPPORT_MAILS`';

	public $schema = [
		'mailid'		=> [ 'type' => BaseModel::TYPE_INT ],
		'firstname' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'lastname' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'mail'			=> [ 'type' => BaseModel::TYPE_STRING ],
		'problem' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'information' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'createdat' 	=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}