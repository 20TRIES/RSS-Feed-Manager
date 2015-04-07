<?php namespace App\Models\Feeds\Repos;

use App\Contracts\ModelContract AS Model;
use App\Helpers\QueryHandlers\PDOQueryHandler AS Builder;
use Carbon\Carbon;
use PDO;

/**
 *  A repository for interacting with Feeds; implemented using the PDO library.
 * @package App\Models\Feeds\Repos
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
class PDOFeedRepository extends FeedRepository {

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function newQuery()
    {
        return new PDOQueryBuilder($this->model());
    }

    /**
     * @param $id
     * @return \App\Contracts\ModelContract[]
     * @TODO Move to a more more appropriate parent class.
     */
    public function find($id)
    {
        $query = $this->newQuery()->where('id', '=', $id);
        return $this->createModels($query->get());
    }

    /**
     * @return \App\Contracts\ModelContract[]
     * @TODO Move to a more more appropriate parent class.
     */
    public function all()
    {
        $query = $this->newQuery();
        return $this->createModels($query->get());
    }

    public function exists()
    {
        $query = $this->newQuery();
        $model_id =  $this->model()->getAttribute('id');
        if ( ! is_null($model_id))
        {
            $query->where('id', '=', $model_id);
        }
        $query->orWhere('name', '=', $this->model()->getAttribute('name'));
        $query->orWhere('address', '=', $this->model()->getAttribute('address'));
        return ! empty($query->get());
    }

    public function existsOrFail()
    {
        if ( ! $this->exists())
        {
            throw new Exception('Model does not exist in database.');
        }
    }

    public function unique()
    {
        return ! $this->exists();
    }

    public function uniqueOrFail()
    {
        if ($this->exists())
        {
            throw new Exception('Model is not unique');
        }
    }

    public function insert()
    {
        $result = $this->newQuery()
            ->table($this->model()->table())
            ->insert($this->model()->getAttributes());

        // Fill the repository model with the newly inserted data.
        // This must be done as some attribute may be left as NULL
        // and hence generated at the time of insertion.
        $new_data = $this->newQuery()
            ->where('id', '=', $result)
            ->get();
        $this->model()->fill( array_pop($new_data) );
    }

    public function update()
    {
        $this->model()->setAttribute('updated_at', Carbon::now('GB'));
        return $this->newQuery()
            ->table($this->model()->table())
            ->update($this->model()->getAttributes())
            ->where('id', '=', $this->model()->getAttribute('id'))
            ->executeUpdate();
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}