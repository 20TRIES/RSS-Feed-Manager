<?php namespace App\ViewComposers;

use App\Contracts\ViewComposerContract;

class TwigViewComposer implements ViewComposerContract {

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    public function __construct()
    {
        $base_dir = $_SERVER['DOCUMENT_ROOT'] . '/../';
        $loader   = new \Twig_Loader_Filesystem($base_dir . 'resources/views');
        $this->twig = new \Twig_Environment($loader, array('cache' => $base_dir . 'storage/views',));

    }

    /**
     * Renders a view.
     * @param string $template
     * @param array $attributes
     * @return string
     */
    public function make($template, Array $attributes = [])
    {
        return $this->twig->render($template, $attributes);
    }
}