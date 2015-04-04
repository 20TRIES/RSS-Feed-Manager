<?php namespace App\Helpers;

use App\Models\FeedItems\FeedItem;
use App\Models\Feeds\Feed;

/**
 * A helper class for reading rss feeds.
 * @package App\Helpers
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
 */
class RssReader {

    /**
     * Gets an array of all of the items within an rss feed.
     * @param \App\Models\Feeds\Feed $feed
     * @return FeedItem[]
     */
    public static function fetch(Feed $feed)
    {
        $dom = (new \DOMDocument());
        $dom->load($feed->getAttribute('address'));
        $items = [];
        foreach ($dom->getElementsByTagName('item') as $node)
        {
            $item =  new FeedItem();
            $item->fill([
                'feed'       => $feed->getAttribute('id'),
                'title'      => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'desc'       => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'address'    => $node->getElementsByTagName('link')->item(0)->nodeValue,
                'created_at' => $node->getElementsByTagName('date')->item(0)->nodeValue
            ]);
            $items[] = $item;
        }
        return $items;
    }

}