<?php namespace App\Http\Controllers;

use App\Contracts\ViewComposerContract AS ViewComposer;
use App\Helpers\ViewComposers\TwigViewComposer;

/**
 * Constructor class that outlines the base functionality that every
 * constructor should have.
 * @package App\Http\Controllers
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
 */
abstract class BaseController {

    /**
     * @var ViewComposer
     */
    protected $view_composer;

    /**
     * Constructor
     * @param ViewComposer $composer
     */
    public function __construct(ViewComposer $composer = NULL)
    {
        $this->view_composer = is_null($composer)
            ? new TwigViewComposer()
            : $composer;
    }

}