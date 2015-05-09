<?php namespace App\Helpers\RSSReaders;

require_once(__DIR__ . '/MagpieRss/rss_fetch.inc');

use App\Contracts\RssReaderContract;
use Carbon\Carbon;

/**
 * A class for reading rss and atom feeds implemented using the MagpieRss
 * see http://magpierss.sourceforge.net for more details of the
 * Magpie package.
 * @package App\Helpers\RSSReaders
 * @author Marcus T <marcust261@icloud.com>
 * @since 07.04.15
 */
class MagpieRssReader implements RssReaderContract {

    public function fetch($url)
    {
        $feed = @ fetch_rss($url);
        return ($feed === FALSE) ? FALSE : $this->processItems($feed->items);
    }

    /**
     * Processes the items returned from a feed, sanitising each one
     * and normalising their attribute names.
     * @param array $items An array of items from an rss feed.
     * @return array An array of processed items.
     */
    protected function processItems(array $items)
    {
        return array_map(function ($item)
        {
            return $this->sanitiseItem( $this->normaliseItem($item) );

        }, $items);
    }

    /**
     * Strips tags from a normalised rss item.
     *
     * Item must be normalised first to ensure that the attributes that
     * are recommended for being sanitised are correctly named.
     * @param array $item An array of item attributes.
     * @return array An array of sanitised item attributes.
     */
    protected function sanitiseItem(array $item)
    {
        $item['address']     = strip_tags($item['address']);
        $item['title']       = strip_tags($item['title']);
        $item['description'] = strip_tags($item['description']);
        return $item;
    }

    /**
     * Normalises the attributes of a feed.
     *
     * Normalises the address, title, description and date attributes;
     * all other attributes are discarded. Date attributes are converted
     * to instances of Carbon.
     * @param array $data An array of rss item attributes.
     * @return array An array of normalised attributes.
     */
    protected function normaliseItem(array $data)
    {
        $output = [];
        $output['address'] = array_key_exists('link', $data)
            ? $data['link']
            : NULL;
        $output['title'] = array_key_exists('title', $data)
            ? $data['title']
            : $output['link'];
        $output['description'] = array_key_exists('description', $data)
            ? $data['description']
            : (array_key_exists('summary', $data)
                ? $data['summary']
                : NULL );
        $output['date'] = array_key_exists('pubdate', $data)
            ? new Carbon($data['pubdate'], 'Europe/London')
            : (array_key_exists('updated', $data)
                ? new Carbon($data['updated'], 'Europe/London')
                : (array_key_exists('dc', $data)
                    ? new Carbon($data['dc']['date'], 'Europe/London')
                    : NULL ));
        return $output;
    }
}