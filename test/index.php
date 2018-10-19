<?php

require $_SERVER['DOCUMENT_ROOT'].'/EasyConnect.php';

$database = new EasyConnect();

echo '<pre>';
print_r($database->dotenv_test());
echo '</pre>';
