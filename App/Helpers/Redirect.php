<?php namespace App\Helpers;

/**
 * A helper class for redirecting a users request.
 * @package App\Helpers
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
 */
class Redirect {

    /**
     * Redirects to the given URI.
     * @param $uri
     * @param int $statusCode
     */
    public static function to($uri, $statusCode = 303)
    {
        header('Location: ' . $_SERVER['HTTP_HOST'] . $uri, true, $statusCode);
        die();
    }
}