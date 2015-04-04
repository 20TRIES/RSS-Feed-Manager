<?php namespace App\Contracts;

/**
 * Handles requests to interact with the applications RSS feeds.
 * @package App\Http\Controllers
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
 */
interface ViewComposerContract {

    /**
     * Renders a view.
     * @param string $template
     * @param array $attributes
     * @return string
     */
    public function make($template, Array $attributes = []);

}