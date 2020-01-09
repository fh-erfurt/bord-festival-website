<?php

class Support_mail extends BaseModel
{
	const TABLENAME = '`SUPPORT_MAILS`';

	public $schema = [
		'MAILID'		=> [ 'type' => BaseModel::TYPE_INT ],
		'FIRSTNAME' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'LASTNAME' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'MAIL'			=> [ 'type' => BaseModel::TYPE_STRING ],
		'PROBLEM' 		=> [ 'type' => BaseModel::TYPE_STRING ],
		'INFORMATION' 	=> [ 'type' => BaseModel::TYPE_STRING ],
		'CREATEDAT' 	=> [ 'type' => BaseModel::TYPE_STRING ]
	];
}