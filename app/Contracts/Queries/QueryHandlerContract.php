<?php namespace App\Contracts\Queries;

use App\Contracts\Queries\QueryContract AS Query;

/**
 * An object for performing database queries.
 * @package App\Contracts
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
abstract class QueryHandlerContract {

    /**
     * Creates a query to insert data into the database.
     * @param array $data
     * @return Query
     */
    public abstract function insert(array $data);

    /**
     * Creates a query to update data in the database.
     * @param array $data
     * @return Query
     */
    public abstract function update(array $data);

    /**
     * Creates a query to select data from the database.
     * @param array $columns
     * @return Query
     */
    public abstract function select(array $columns);

    /**
     * Executes a query.
     * @param QueryContract $query
     * @return FALSE|array If the query fails, FALSE will be returned.
     *  When testing for equality '===' should be used. If the query
     *  is successful the results will be returned in an array.
     */
    public abstract function execute(Query $query);

}