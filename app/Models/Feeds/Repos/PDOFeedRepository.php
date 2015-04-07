<?php namespace App\Models\Feeds\Repos;

use App\Contracts\ModelContract AS Model;
use App\Contracts\Queries\QueryHandlerContract AS QueryHandler;
use App\Helpers\QueryHandlers\PDOQueryHandler;

/**
 *  A repository for interacting with Feeds; implemented using the PDO library.
 * @package App\Models\Feeds\Repos
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
class PDOFeedRepository extends FeedRepository {

    public function __construct(Model $model, QueryHandler $handler = NULL)
    {
        $handler = is_null($handler) ? new PDOQueryHandler() : $handler;
        parent::__construct($model, $handler);
    }

    public function find($id)
    {
        $results = $this->handler
            ->select(['*'])
            ->table('feeds')
            ->where('id', '=', $id)
            ->execute();
        return $this->createModels($results);
    }

    public function all()
    {
        $results = $this->handler
            ->select(['*'])
            ->table('feeds')
            ->execute();
        return $this->createModels($results);
    }

    public function exists()
    {
        $results = $this->handler
            ->select(['*'])
            ->table('feeds')
            ->where('id', '=', $this->model()->getAttribute('id'))
            ->where('name', '=', $this->model()->getAttribute('name'))
            ->orWhere('address', '=', $this->model()->getAttribute('address'))
            ->execute();
        return !empty($results);
    }

    public function unique()
    {
        return ! $this->exists();
    }

    public function save()
    {
        return $this->unique() ? $this->insertModel() : $this->updateModel();
    }

    /**
     * @throws \Exception
     * @TODO: Implement method
     */
    protected function updateModel()
    {
        throw new \Exception('The update method still needs implementing.');
    }

    protected function insertModel()
    {
        $result = $this->handler
            ->insert($this->model()->getAttributes())
            ->table($this->model()->table())
            ->execute();
        if ($result === FALSE) return FALSE;

        // Fill the current model with the data from the newly inserted record.
        // Some fields are automatically set when inserted and as such need
        // to be transferred to the current model instance.
        $find_results = $this->model()->find($result);
        $new_attributes = array_pop($find_results)->getAttributes();
        $this->model()->fill($new_attributes);
        return TRUE;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}