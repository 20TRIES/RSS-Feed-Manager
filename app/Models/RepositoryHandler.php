<?php namespace App\Models;

/**
 * A class that handles the instantiation of repositories.
 * @since 21.03.15
 * @author Marcus T <marcust261@icloud.com>
 * @TODO Needs Testing
 */
abstract class RepositoryHandler {

    /**
     * @var array Class Repositories.
     */
    private $repositories = [];

    /**
     * Gets one of a class's repositories.
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->repositories[$name];
    }

    /**
     * Determines if a repository has been made.
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->repositories);
    }

    /**
     * Sets one of a class's repositories.
     * @param $name
     * @param $repository
     */
    protected function set($name, $repository)
    {
        $this->repositories[$name] = $repository;
    }

    /**
     * Makes an instance of a repository for a class.
     *
     * Must be implemented by any child classes as this is framework and or
     * implementation specific.
     * @param $name
     * @param $repository_class
     * @param array $params
     * @return mixed
     */
    public abstract function make($name, $repository_class, array $params = []);

    /**
     * Overrides a repository within a class.
     *
     * This is for use when testing. An instance of a repository can be
     * substituted for a class's current repository.
     * @param $name
     * @param $repository
     * @throws \Exception
     */
    public function override($name, $repository)
    {
        if ($this->hasRepository($name))
        {
            $this->set($name, $repository);
        }
        else
        {
            throw new \Exception('Repository cannot be overridden: Is not set!');
        }
    }
}