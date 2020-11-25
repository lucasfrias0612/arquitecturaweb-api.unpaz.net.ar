<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\PostgreSQL;

class PostgresqlConnection
{
    private $connection;

    /**
     * PostgresqlConnection constructor.
     * @param string $connectionString
     */
    public function __construct(string $connectionString)
    {
        $this->connection = pg_connect($connectionString);
    }

    /**
     * @param string $query
     * @return array
     */
    public function executeSelectQuery(string $query)
    {
        $res=[];
        $result=pg_query($this->connection, $query) or die('La consulta fallo: ' . pg_last_error());
        $i=0;
        while ($line = pg_fetch_assoc($result, null)) {
            $res[$i]=$line;
            $i++;
        }
        return $res;;
    }

    /**
     * @return false|resource
     */
    public function getConnection()
    {
        return $this->connection;
    }
}