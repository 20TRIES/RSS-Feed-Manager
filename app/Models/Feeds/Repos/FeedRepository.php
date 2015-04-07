<?php namespace App\Models\Feeds\Repos;

use App\Contracts\ModelContract AS Model;
use App\Models\Feeds\Feed;
use App\Contracts\RepositoryContract;

/**
 * A repository for interacting with Feeds/
 * @package App\Models\Feeds\Repos
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
abstract class FeedRepository implements RepositoryContract {

    /**
     * @var Model
     */
    private $model;

    /**
     * Constructor
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Gets the repositories model.
     * @return Model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Finds a Feed.
     * @param $id
     * @return Feed[]
     */
    public abstract function find($id);

    /**
     * Inserts the repository model into the database.
     * @return Feed
     */
    public abstract function insert();

    /**
     * Deletes a Feed.
     * @param $id
     */
    public abstract function delete($id);

    /**
     * Creates a new query.
     */
    public abstract function newQuery();

    /**
     * Creates a model from a set of data that has the same class
     * as the current model.
     * @param array $data
     * @return Model
     */
    public function createModel(array $data)
    {
        $class = get_class($this->model());
        return (new $class())->fill($data);
    }

    /**
     * Repeatedly performs createModel for a set of model data sets.
     * @param array $data
     * @return Model[]
     */
    public function createModels(array $data)
    {
        $models = [];
        foreach($data AS $model_data)
        {
            $model = $this->createModel($model_data);
            $models[$model->getAttribute('id')] = $model;
        }
        return $models;
    }

}