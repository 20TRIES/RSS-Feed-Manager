<?php namespace App\Helpers\Queries;

use App\Contracts\Queries\QueryHandlerContract AS Handler;
use App\Contracts\Queries\QueryContract;

/**
 * A query object for build Mysql queries.
 * query strings.
 * @package App\Helpers\QueryBuilders
 * @author Marcus T <marcust261@icloud.com>
 * @since 06.04.15
 */
class MysqlQuery implements QueryContract {

    /**
     * @var string The table that the query will be executed on.
     */
    private $table;

    /**
     * @var string The type of the query (From class constants).
     */
    private $query_type = NULL;

    /**
     * @var array The columns that will be queried.
     */
    private $columns;

    /**
     * @var array The query conditions.
     */
    private $conditions = [];

    /**
     * @var array The values bound to the query operators (SELECT, INSERT, UPDATE...)
     */
    private $operator_bindings  = [];

    /**
     * @var array The values bound to the query conditions (WHERE).
     */
    private $condition_bindings = [];

    /**
     * @var Builder A query builder that can be called at the time of execution.
     */
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function execute()
    {
        return $this->handler->execute($this);
    }

    public function select(array $columns)
    {
        $this->setQueryType(self::SELECT);
        $this->columns = $columns;
        return $this;
    }

    public function insert(array $data)
    {
        $this->setQueryType(self::INSERT);
        $this->columns = array_keys($data);
        $this->bindValuesToOperator($data);
        return $this;
    }

    public function update(array $data)
    {
        $this->setQueryType(self::UPDATE);
        $this->columns = array_keys($data);
        $this->bindValuesToOperator($data);
        return $this;
    }

    public function getStatement()
    {
        if ( ! $this->hasTable())
        {
            throw new \Exception('Table must be set before a statement can be generated.');
        }
        if ( ! $this->hasQueryType())
        {
            throw new \Exception('Query type must be set before a statement can be generated.');
        }
        switch ($this->query_type)
        {
            case self::SELECT:
                $output = $this->generateSelectStatement();
                break;
            case self::INSERT:
                $output = $this->generateInsertStatement();
                break;
            case self::UPDATE:
                $output = $this->generateUpdateStatement();
                break;
            default:
                throw new \Exception('Query type not recognised.');
        }
        return $output . $this->generateConditionString();
    }

    public function table($name)
    {
        $this->table = $name;
        return $this;
    }

    public function where($column, $operator, $value, $type = 'AND')
    {
        $this->conditions[] = [
            'attribute' => $column,
            'operator'  => $operator,
            'type'      => $type
        ];
        $this->bindValuesToCondition([$value]);
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        return $this->where($column, $operator, $value, 'OR');
    }

    public function andWhere($column, $operator, $value)
    {
        return $this->where($column, $operator, $value, 'AND');
    }

    public function getBindings()
    {
        $index = 1;
        $bindings = [];
        foreach($this->operator_bindings as $value)
        {
            $bindings[$index++] =  $value;
        }
        foreach($this->condition_bindings as $value)
        {
            $bindings[$index++] =  $value;
        }
        return $bindings;
    }

    /**
     * Determines if a string matches a valid query type.
     * @param string $type
     * @return bool
     */
    protected function isValidQueryType($type)
    {
        switch($type)
        {
            case self::SELECT:
            case self::INSERT:
            case self::UPDATE:
                return TRUE;
            default:
                return FALSE;
        }
    }

    /**
     * Sets the query type; can only be done once.
     * @param string $type
     * @throws \Exception
     */
    protected function setQueryType($type)
    {
        if ( ! is_null($this->query_type))
        {
            throw new \Exception('Query type cannot be changed');
        }
        if ( ! $this->isValidQueryType($type))
        {
            throw new \InvalidArgumentException('Invalid query type');
        }
        $this->query_type = $type;
    }

    /**
     * Determines if a query has a type.
     * @return bool
     */
    protected function hasQueryType()
    {
        return ! empty($this->query_type);
    }

    public function getType()
    {
        return $this->query_type;
    }

    /**
     * Generates a select statement query string.
     * @return string
     */
    protected function generateSelectStatement()
    {
        $table = $this->table;
        $columns_string  = $this->generateColumnsString();
        return "SELECT $columns_string FROM $table";
    }

    /**
     * Generates an insert statement query string.
     * @return string
     */
    protected function generateInsertStatement()
    {
        $table = $this->table;
        $columns_string  = $this->generateColumnsString();
        $bindings_string = $this->generateBindingsString();
        return  "INSERT INTO $table ($columns_string) VALUES($bindings_string)";
    }

    /**
     * Generates a update statement query string.
     * @return string
     */
    protected function generateUpdateStatement()
    {
        $table = $this->table;
        $combined_bindings = $this->generateCombinedBindingsString();
        return "UPDATE $table SET $table.$combined_bindings";
    }

    /**
     * Generates a placeholder string from the query columns
     * in the format "column1 = ?, column2 = ?".
     * @return string
     */
    protected function generateCombinedBindingsString()
    {
        return implode(' = ?, ', $this->columns) . ' = ?';
    }

    /**
     * Generates a string of the queries columns in the format
     * "column1, column2, column3".
     * @return string
     */
    protected function generateColumnsString()
    {
        return implode(', ', $this->columns);
    }

    /**
     * Generates a string of placeholders in the format
     * "?, ?, ?".
     *
     * A placeholder is generated for value that has been bound
     * to the query.
     * @return string
     */
    protected function generateBindingsString()
    {
        return str_repeat('?, ', $this->countBindings()-1) . '?';
    }

    /**
     * Generates a string of all the query conditions in the format
     * "WHERE column1 = ? AND column2 = ? OR column3 = ?".
     * @return string
     */
    protected function generateConditionString()
    {
        $output = '';
        foreach ($this->conditions AS $condition)
        {
            $items = [];
            if ( ! empty($output)) array_push($items, $condition['type']);
            array_push($items, $condition['attribute']);
            array_push($items, $condition['operator']);
            array_push($items, '? ');
            $output .= implode(' ', $items);
        }
        return empty($output) ? '' : ' WHERE ' . $output;
    }

    /**
     * Determines whether the queries table has been set.
     * @return bool
     */
    protected function hasTable()
    {
        return ! is_null($this->table);
    }

    /**
     * Gets the number of values that the query has bound.
     * @return int
     */
    protected function countBindings()
    {
        return count($this->operator_bindings) + count($this->condition_bindings);
    }

    /**
     * Binds an array of values to the query operators (SELECT, INSERT, UPDATE...)
     * @param array $bindings
     */
    protected function bindValuesToOperator(array $bindings)
    {
        $this->operator_bindings += $bindings;
    }

    /**
     * Binds an array of values to the query conditions (WHERE).
     * @param array $bindings
     */
    protected function bindValuesToCondition(array $bindings)
    {
        $this->condition_bindings = array_merge($this->condition_bindings, $bindings);
    }
}