# EasyConnect
A simple PDO manager to manage connections and reduce code in non-framework PHP scripts.

Tested:
- [x] SQLite
- [ ] MySQL
- [ ] PostgreSQL 
## Setup:
1. 
2. Open .env.example and copy the settings you need to .env
3. Make sure .env is in root folder
4. Open .gitignore and add .env if use git
5. Start using EasyConnect!

## Usage:
Load class 
````PHP
require __DIR__ . '/vendor/autoload.php';

use EasyConnect\EasyConnect;

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
Inserting / Updating / Deleting data
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
