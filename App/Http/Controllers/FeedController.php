<?php namespace App\Http\Controllers;

use app\Contracts\RssReaderContract AS RssReader;
use App\Contracts\ViewComposerContract as ViewComposer;
use App\Helpers\Redirect;
use App\Helpers\RSSReaders\MagpieRssReader;
use App\Models\Feeds\Feed;

/**
 * Handles requests to interact with the applications RSS feeds.
 * @package App\Http\Controllers
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
*/
class FeedController extends BaseController {

    /**
     * @var RssReader
     */
    protected $rss_reader;

    public function __construct(ViewComposer $composer = NULL, RssReader $rss_reader = NULL)
    {
        parent::__construct($composer);
        $this->rss_reader = is_null($rss_reader) ? new MagpieRssReader() : $rss_reader;
    }

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
        $feed       = array_pop( (new Feed())->find($feed_id) );
        $attributes = ['title' => $feed->getAttribute('name')];
        $feed_items = $this->rss_reader->fetch($feed->getAttribute('address'));

        $attributes += ($feed_items === FALSE)
            ? ['error' => preg_replace('/MagpieRSS:/', '', error_get_last()['message'])]
            : ['items' => $feed_items];

        return $this->view_composer->make('feeds/show.twig', $attributes);
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
            'name'    => strip_tags($_POST['name']),
            'address' => strip_tags($_POST['address'])
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