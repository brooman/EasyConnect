<?php

declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';

class EasyConnect
{
    //PDO object
    private $pdo;
    private $dotenv;

    public function __construct()
    {
        $this->dotenv = new Dotenv\Dotenv(__DIR__);
        $this->dotenv->load();

        if ('sqlite' === strtolower(getenv('EC_driver'))) {
            $this->pdo = 'sqlite:'.getenv('EC_filepath');
        }

        if ('mysql' === strtolower(getenv('EC_driver'))) {
            //Config
            $host = 'host='.getenv('EC_host');
            $dbname = 'dbname='.getenv('EC_dbname');
            $username = getenv('EC_username');
            $password = getenv('EC_password');

            //Create connection
            $this->pdo = new PDO("mysql:$host;$dbname", $username, $password);
        }

        if ('pgsql' === strtolower(getenv('EC_driver'))) {
            $host = 'host='.getenv('EC_host');
            $dbname = 'dbname='.getenv('EC_dbname');
            $username = 'user='.getenv('EC_username');
            $password = 'password='.getenv('EC_password');

            $this->pdo = new PDO("pgsql:$host;$dbname;$username;$password");
        }
        // Set errormode to exceptions
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get data from database.
     *
     * @param string $query
     * @param array  $params (Optional)
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
     * @param string $query
     * @param array  $params (Optional)
     */
    public function setData(string $query, ?array $params = []): string
    {
        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($params);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
