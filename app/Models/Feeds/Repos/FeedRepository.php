<?php namespace App\Models\Feeds\Repos;

use App\Contracts\ModelContract AS Model;
use App\Models\Feeds\Feed;
use App\Contracts\RepositoryContract;

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
     * @return Feed
     */
    public abstract function find($id);

    /**
     * Creates a new Feed.
     * @param array $attributes
     * @return Feed
     */
    public abstract function create(Array $attributes);

    /**
     * Deletes a Feed.
     * @param $id
     */
    public abstract function delete($id);

}