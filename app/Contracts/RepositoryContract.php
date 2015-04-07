<?php namespace App\Contracts;

use App\Contracts\ModelContract AS Model;

/**
 * A repository for interacting with data in the database.
 * @package App\Models
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
interface RepositoryContract {

    /**
     * Constructor
     * @param Model $model
     */
    public function __construct(Model $model);

    /**
     * Gets a repository's model.
     * @return Model
     */
    public function model();

    /**
     * Gets all of records from a repository.
     * @return array
     */
    public function all();

}