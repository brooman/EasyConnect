<?php

require $_SERVER['DOCUMENT_ROOT'].'/EasyConnect.php';

$database = new EasyConnect();

echo $database->getStatus();

$query = 'SELECT * FROM user';
$database->getData($query);
