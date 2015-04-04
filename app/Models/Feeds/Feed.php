<?php namespace App\Models\Feeds;

use App\Contracts\ModelContract;
use App\Models\BaseModel;
use App\Models\Feeds\Repos\FeedRepositoryTrait;

/**
 * Stores and interacts with a RSS Feed.
 * @package App\Models
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
 */
class Feed extends BaseModel implements ModelContract {

    use FeedRepositoryTrait;

    protected $attributes = [
        'id'          => NULL,
        'name'        => NULL,
        'address'     => NULL,
        'created_at'  => NULL,
        'updated_at'  => NULL,
    ];

    protected $cast = [
        'created_at' => 'Carbon\Carbon',
        'updated_at' => 'Carbon\Carbon'
    ];

    public function __construct()
    {
        // Call parent method.
        parent::__construct();

        // Perform setup on traits used.
        $this->setupFeedRepositoryTrait(func_get_args());
    }

}