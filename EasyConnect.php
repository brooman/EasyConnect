<?php

declare(strict_types=1);

class EasyConnect
{
    //PDO object
    private $pdo;

    public function __construct()
    {
        $this->fileName = $_SERVER['DOCUMENT_ROOT'].'/database/newsfeed.sqlite';
        //Create PDO connection
        // Create (connect to) SQLite database in file
        $dsn = "sqlite:$this->fileName";
        $this->pdo = new PDO($dsn);
        // Set errormode to exceptions
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION);
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
