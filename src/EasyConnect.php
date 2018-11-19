<?php

declare(strict_types=1);

namespace EasyConnect;

use PDO;

class EasyConnect
{
    private $pdo;
    private $error;

    /**
     * Constructor.
     *
     * @param string|null $env
     */
    public function __construct($config)
    {
        try {
            if ('sqlite' === strtolower($config['driver'])) {
                //Load SQLite config && Create SQLite connection
                $this->pdo = new PDO('sqlite:'.$config['filepath']);
            }

            if ('mysql' === strtolower($config['driver'])) {
                //Load MySQL config
                $host = 'host='.$config['host'];
                $port = 'port='.$config['port'];
                $dbname = 'dbname='.$config['dbname'];
                $username = $config['username'];
                $password = $config['password'];

                //Create MySQL connection
                $this->pdo = new PDO("mysql:$host;$port;$dbname", $username, $password);
            }

            if ('pgsql' === strtolower($config['driver'])) {
                //Load PostgreSQL config
                $host = 'host='.$config['host'];
                $port = 'port='.$config['port'];
                $dbname = 'dbname='.$config['dbname'];
                $username = $config['username'];
                $password = $config['password'];

                //Create PostgreSQL connection
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
        return null;
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
     * Get single array from database
     * Useful when fetching from single row.
     *
     * @param string     $query
     * @param array|null $params
     *
     * @return array
     */
    public function getSingle(string $query, ?array $params = []): array
    {
        $sth = $this->pdo->prepare($query);
        $sth->execute($params);

        return $sth->fetch(PDO::FETCH_ASSOC);
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
