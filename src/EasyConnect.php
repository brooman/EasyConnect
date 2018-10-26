<?php

declare(strict_types=1);

namespace EasyConnect;

use Dotenv;
use PDO;

class EasyConnect
{
    private $pdo;
    private $dotenv;
    private $error;

    public function __construct()
    {
        $this->dotenv = new Dotenv\Dotenv($_SERVER['DOCUMENT_ROOT']);
        $this->dotenv->load();
        try {
            if ('sqlite' === strtolower(getenv('EC_driver'))) {
                $this->pdo = new PDO('sqlite:'.$_SERVER['DOCUMENT_ROOT'].'/'.getenv('EC_filepath'));
            }

            if ('mysql' === strtolower(getenv('EC_driver'))) {
                //Config
                $host = 'host='.getenv('EC_host');
                $port = 'port='.getenv('EC_port');
                $dbname = 'dbname='.getenv('EC_dbname');
                $username = getenv('EC_username');
                $password = getenv('EC_password');

                //Create connection
                $this->pdo = new PDO("mysql:$host;$port;$dbname", $username, $password);
            }

            if ('pgsql' === strtolower(getenv('EC_driver'))) {
                $host = 'host='.getenv('EC_host');
                $dbname = 'dbname='.getenv('EC_dbname');
                $username = 'user='.getenv('EC_username');
                $password = 'password='.getenv('EC_password');

                $this->pdo = new PDO("pgsql:$host;$port;$dbname;$username;$password");
            }
            // Set errormode to exceptions
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = $e;
        }
    }

    /**
     * Get message from PDOExceptions.
     *
     * @return string|null
     */
    public function getError(): ?string
    {
        if ($this->error) {
            return $this->status->getMessage();
        }

        //Returns NULL if $this->error is empty
        return NULL;
    }

    /**
     * Get data from database.
     *
     * @param string     $query
     * @param array|null $params
     *
     * @return array
     */
    public function getData(string $query, ?array $params = []): array
    {
        $sth = $this->pdo->prepare($query);
        $sth->execute($params);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * INSERT / UPDATE / DELETE data.
     *
     * @param string     $query
     * @param array|null $params
     */
    public function setData(string $query, ?array $params = [])
    {
        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($params);
        } catch (PDOException $e) {
            $this->error = $e;
        }
    }
}
