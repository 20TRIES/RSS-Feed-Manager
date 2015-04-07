<?php namespace App\Helpers\QueryHandlers;

use App\Contracts\Queries\QueryHandlerContract;
use App\Contracts\Queries\QueryContract AS Query;
use App\Helpers\Config;
use App\Helpers\Exception;
use App\Helpers\Queries\MysqlQuery;
use PDO;

/**
 * An object for performing database queries.
 * @package App\Helpers
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
class PDOQueryHandler extends QueryHandlerContract {

    /**
     * @var PDO A database connection.
     */
    private $connection;

    /**
     * @TODO Inject connection into class.
     */
    public function __construct()
    {
        $this->connection = $this->newConnection();
    }

    public function select(array $columns)
    {
          return (new MysqlQuery($this))->select($columns);
    }

    public function insert(array $data)
    {
        return (new MysqlQuery($this))->insert($data);
    }

    public function update(array $data)
    {
        return (new MysqlQuery($this))->update($data);
    }

    public function execute(Query $query)
    {
        $statement = $this->connection->prepare( $query->getStatement() );
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        foreach($query->getBindings() AS $index => $value)
        {
            $result = $statement->bindValue($index, $value);
            if ($result === FALSE) throw new Exception("Failed when binding parameter $index => $value");
        }
        if ($statement->execute() === FALSE) return FALSE;
        switch ($query->getType())
        {
            case Query::INSERT:
                return $this->connection->lastInsertId();
            default:
                return $statement->fetchAll();
        }
    }

    /**
     * Creates a new connection to the database.
     * @return PDO
     */
    protected function newConnection()
    {
        $conf = Config::get('db', 'MYSQL');
        $dsn  = "mysql:host=" . $conf['DB_HOST'] . ";dbname=" . $conf['DB_NAME'];
        return new PDO($dsn, $conf['DB_USER'], $conf['DB_PASS']);
    }
}