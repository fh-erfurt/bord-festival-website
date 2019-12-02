<?php


$dns = 'mysql:host=localhost;dbname=festival';
$dbuser = 'root';
$dbpassword = 'nH56v@L2m+QZM81#-S24$ER\wfQW.jsd';
$options    = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];


$database = null;

try
{
    $database = new PDO($dns, $dbuser, $dbpassword, $options);
	$database->exec("SET CHARACTER SET utf8");
}
catch(\PDOException $e)
{
	die( 'Database connection failed: ' . $e->getMessage() );
}