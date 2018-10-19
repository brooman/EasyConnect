# EasyConnect
A simple PDO manager to manage connections and reduce code in non-framework PHP scripts.

Tested:
- [x] SQLite
- [] MySQL
- [] PostgreSQL 

## Usage:
Load class 
````PHP
require 'path/to/EasyConnect.php';
$database = new EasyConnect();
````
Retrive data from database
````php
//Example query
$query = 'SELECT * FROM user';

//Params (Optional but highly advised to protect from SQL injections)
$params = [];

//Returns array of results
$result = $database->getData($query, $params);

````

````php
//Insert data
//Query (Required)
$query = 'INSERT INTO user (username, password) VALUES (:username, :password)';

//Params (Optional but highly advised to protect from SQL injections)
$params = [
    ':username' => $_POST['username'],
    ':password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
];

//Insert into Database
$database->insertData($query,$params);
````

Retrive PDO exceptions
````PHP
//Gets the error message if PDO exception was triggered.
$database->getError();
````
