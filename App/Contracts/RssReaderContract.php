<?php namespace App\Contracts;

/**
 * A contract for classes that can be used to read rss feeds.
 * @package App\Contracts
 * @author Marcus T <marcust261@icloud.com>
 * @since 07.04.15
 */
interface RssReaderContract {

    /**
     * Fetches the data items from a rss feed.
     * @param string $url
     * @return array|bool Returns FALSE if an error occurs. Test for
     * equality using the '===' operator. If no error occurs, the
     * rss feed items are returned in an array.
     */
    public function fetch($url);

}