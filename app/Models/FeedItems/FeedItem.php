<?php namespace App\Models\FeedItems;

use App\Contracts\ModelContract;
use App\Helpers\Feed;
use App\Models\BaseModel;

/**
 * Stores and interacts with a RSS Feed item.
 * @package App\Helpers
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
class FeedItem extends BaseModel implements ModelContract {

    protected $attributes = [
        'feed'       => NULL,
        'title'      => NULL,
        'desc'       => NULL,
        'address'    => NULL,
        'created_at' => NULL,
        'updated_at' => NULL,
    ];

    protected $cast = [
        'created_at' => 'Carbon\Carbon',
        'updated_at' => 'Carbon\Carbon'
    ];

}