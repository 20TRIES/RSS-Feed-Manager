<?php namespace App\Helpers;

/**
 * A helper class for reading rss feeds.
 * @package App\Helpers
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
 */
class RssReader {

    /**
     * Gets an array of all of the items within an rss feed.
     * @param Feed $feed
     * @return FeedItemDTO[]
     */
    public static function fetch(Feed $feed)
    {
        $feed = (new \DOMDocument())->load($feed->address);
        $items = [];
        foreach ($feed->getElementsByTagName('item') as $node)
        {
            $items[] = FeedItemDTO::create([
                'feed'  => $feed->getAttribute('id'),
                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'desc'  => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'link'  => $node->getElementsByTagName('link')->item(0)->nodeValue,
                'date'  => $node->getElementsByTagName('date')->item(0)->nodeValue
            ]);
        }
        return $items;
    }

}