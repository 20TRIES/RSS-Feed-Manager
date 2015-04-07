<?php namespace App\Models\Feeds\Repos;

use App\Contracts\ModelContract AS Model;
use App\Models\Feeds\Feed;
use App\Contracts\RepositoryContract;
use App\Contracts\Queries\QueryHandlerContract AS QueryHandler;

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
    protected $model;

    /**
     * @var QueryHandler
     */
    protected $handler;

    /**
     * Constructor
     * @param Model $model
     * @param QueryHandler $handler
     */
    public function __construct(Model $model, QueryHandler $handler = NULL)
    {
        $this->model   = $model;
        $this->handler = $handler;
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
     * Saves teh model and updates any of teh model's attribute that a
     * are automatically set during this process, e.g. updated_at.
     * @return bool
     */
    public abstract function save();

    /**
     * Deletes a Feed.
     * @param $id
     */
    public abstract function delete($id);

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