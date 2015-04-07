<?php namespace App\Contracts\Queries;

use App\Contracts\Queries\QueryHandlerContract AS Handler;

/**
 * A contract for Query objects that can be used to build SQL
 * query strings.
 * @package App\Contracts
 * @author Marcus T <marcust261@icloud.com>
 * @since 06.04.15
 */
interface QueryContract  {

    /**
     * A query type used for queries that select data.
     */
    const SELECT = 'select';

    /**
     * A query type used for queries that insert data.
     */
    const INSERT = 'insert';

    /**
     * A query type used for queries that update data.
     */
    const UPDATE = 'update';

    /**
     * Constructor
     * @param Handler $handler
     */
    public function __construct(Handler $handler);

    /**
     * Hands the query to the query handler for execution and returns the results.
     */
    public function execute();

    /**
     * Configures a query for selecting data.
     * @param array $columns An array of column names that should be returned.
     * @return $this
     */
    public function select(array $columns);

    /**
     * Configures a query for inserting data.
     * @param array $data An array of data. Keys should be set to the column names
     * and values should be set to the column values.
     * @return $this
     */
    public function insert(array $data);

    /**
     * Configures a query for updating data.
     * @param array $data An array of data. Keys should be set to the names of the
     * columns that should be updated. The Values should be set to the new values.
     * @return $this
     */
    public function update(array $data);

    /**
     * Generates a query string based on the current object configuration.
     * @return string
     */
    public function getStatement();

    /**
     * Gets an array of the queries bound values.
     * @return array
     */
    public function getBindings();

    /**
     * Gets the type of the query.
     * @return string
     */
    public function getType();

    /**
     * Sets the table for the query.
     * @param string $name The table name.
     * @return $this
     */
    public function table($name);

    /**
     * Adds a where condition to the query.
     * @param string $column The column that the condition applies to.
     * @param string $operator the operator that is used.
     * @param string $type The type of condition that should be used
     * to join the condition to any previous conditions. If not
     * previous conditions exist, this value will be ignored and
     * as such can be left as it's default value of 'AND'.
     * @param $value The columns expected value.
     * @return $this
     * @TODO Implement NULL type for the first condition applied.
     */
    public function where($column, $operator, $value, $type = 'AND');

    /**
     * Wrapper for the where function which sets the type to 'OR'.
     *
     * Can be used when adding multiple successive conditions to a
     * query to improve code readability.
     * @param $column
     * @param $operator
     * @param $value
     * @return $this
     */
    public function orWhere($column, $operator, $value);

    /**
     * Wrapper for the where function which sets the type to 'AND'.
     *
     * Can be used when adding multiple successive conditions to a
     * query to improve code readability.
     * @param $column
     * @param $operator
     * @param $value
     * @return $this
     */
    public function andWhere($column, $operator, $value);

}