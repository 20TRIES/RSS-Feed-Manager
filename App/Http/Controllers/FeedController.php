<?php namespace App\Http\Controllers;

use App\Helpers\Redirect;
use App\Helpers\RssReader;
use App\Models\Feeds\Feed;

/**
 * Handles requests to interact with the applications RSS feeds.
 * @package App\Http\Controllers
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
*/
class FeedController extends BaseController {

    /**
     * Handles requests to the index page.
     */
    public function index()
    {
        return $this->view_composer->make('feeds/index.twig', [
            'title'        => 'All Feeds',
            'link_to_add'  => 'http://' . $_SERVER['HTTP_HOST'] . '/add',
            'link_to_show' => 'http://' . $_SERVER['HTTP_HOST'] . '/show/',
            'items'        => (new Feed())->all()
        ]);
    }

    /**
     * Handles a request to show a RSS Feed.
     * @param $feed_id
     * @return string
     */
    public function show($feed_id)
    {
        $feed = array_pop( (new Feed())->find($feed_id) );
        return $this->view_composer->make('feeds/show.twig', [
            'title'   => $feed->getAttribute('name'),
            'items'   => RssReader::fetch($feed)
        ]);
    }

    /**
     * Handles a request to create a new RSS Feed.
     * @return string
     */
    public function create()
    {
        return $this->view_composer->make('feeds/create.twig', [
            'title'          => 'Add Feed',
            'submit_address' => 'http://' . $_SERVER['HTTP_HOST'] . '/add',
        ]);
    }

    /**
     * Handles a request to store a new RSS Feed.
     */
    public function store()
    {
        $feed = (new Feed)->fill([
            'name'    => $_POST['name'],
            'address' => $_POST['address']
        ]);
        $feed->save();
        return Redirect::to('/show/' . $feed->getAttribute('id'));
    }

    /**
     * Handles a request to destroy a RSS Feed.
     * @return string
     * @param $feed_id
     * @TODO Needs implementing.
     */
    public function destroy($feed_id)
    {

    }

}