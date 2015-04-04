<?php namespace App\Models;

/**
 * A repository handler implemented using only PHP.
 * @since 04.04.15
 * @author Marcus T <marcust261@icloud.com>
 */
class PhpRepositoryHandler extends RepositoryHandler {

    private $repositories = [

        'FeedRepository' => 'App\Models\Feeds\Repos\PDOFeedRepository'

    ];

    public function make($name, $repository_class, array $params = [])
    {
        if ( ! array_key_exists($repository_class, $this->repositories))
        {
            throw new \InvalidArgumentException('Unknown repository class.');
        }
        $class = $this->repositories[$repository_class];
        $this->set($name, new $class(...$params));
    }

}