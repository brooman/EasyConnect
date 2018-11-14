# EasyConnect
A simple PDO manager to manage connections and reduce code in non-framework PHP scripts.

Tested:
- [x] SQLite
- [ ] MySQL
- [ ] PostgreSQL 
## Setup:

1. Install [Composer](https://getcomposer.org/) and run ```composer require laykith/easyconnect``` in your project.
2. Start using EasyConnect

### Recommended
1. Add [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) with ```composer require vlucas/phpdotenv```
2. Add your .env file to .gitignore

## Usage:
Load class 
````PHP
require __DIR__ . '/vendor/autoload.php';

use EasyConnect\EasyConnect;

//Example configs (Use what you need based on driver)
$config = [
    'driver' => 'Sqlite', //MySQL SQLite pgsql - (Case Insensetive)
    'filepath' => '/database/users.db', //required for: SQLite
    'host' => 'localhost', //required for: MySQL & pgsql
    'port' => '3306', //required for: MySQL & pgsql
    'dbname' => 'users', //required for: MySQL & pgsql
    'username' => 'root', //required for: MySQL & pgsql
    'password' => 'password123', //required for: MySQL & pgsql
];

//Suggestion: Use vlucas/phpdotenv package to load values
$config = [
    'driver' => getEnv('database_driver'), //MySQL SQLite pgsql - (Case Insensetive)
    'filepath' => getEnv('database_filepath'), //required for: SQLite
    'host' => getEnv('database_host'), //required for: MySQL & pgsql
    'port' =>  getEnv('database_port'), //required for: MySQL & pgsql
    'dbname' => getEnv('database_name'), //required for: MySQL & pgsql
    'dbname' => getEnv('database_name'), //required for: MySQL & pgsql
    'password' => getEnv('password'), //required for: MySQL & pgsql
];

$database = new EasyConnect($config);
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
## License

[MIT](LICENSE) © [André Broman](https://github.com/laykith/)
