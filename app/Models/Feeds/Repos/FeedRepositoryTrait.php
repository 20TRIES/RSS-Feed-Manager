<?php namespace App\Models\Feeds\Repos;


use App\Models\Feeds\Feed;

/**
 * A repository for interacting with a Feed.
 * Class FeedRepositoryTrait
 * @package App\Models\Feeds\Repos
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
trait FeedRepositoryTrait {

    private function setupFeedRepositoryTrait($params)
    {
        $this->makeRepository('feeds', 'FeedRepository', [$this]);
    }

    /**
     * Finds a Feed.
     * @param $id
     * @return Feed
     */
    public function find($id)
    {
        return $this->getRepository('feeds')->find($id);
    }

    /**
     * Gets all Feeds.
     * @return Feed[]
     */
    public function all()
    {
        return $this->getRepository('feeds')->all();
    }

    /**
     * Creates a new Feed.
     * @param array $attributes
     * @return Feed
     */
    public function create(Array $attributes)
    {
        return $this->getRepository('feeds')->create($attributes);
    }

    /**
     * Deletes a Feed.
     * @param $id
     */
    public function delete($id)
    {
        return $this->getRepository('feeds')->delete($id);
    }

}