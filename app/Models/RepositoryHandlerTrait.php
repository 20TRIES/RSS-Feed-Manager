<?php namespace App\Models;
use App\Contracts\RepositoryContract;

/**
 * A trait that makes simplifies calls to the Repository Handler.
 * @since 21.03.15
 * @author Marcus T <marcust261@icloud.com>
 * @package App\Repositories
 */
trait RepositoryHandlerTrait {

    /**
     * @var RepositoryHandler
     */
    private $repository_handler = NULL;

    /**
     * @var string The class name of the default repository handler.
     */
    private $default_repository_handler = 'App\Models\PhpRepositoryHandler';

    /**
     * Performs any setup that is required by the trait.
     * @param $params
     */
    private function setupRepositoryHandlerTrait($params)
    {
        // Look for a repository handler in the parameters.
        foreach($params AS $parameter)
        {
            if ($parameter instanceof RepositoryHandler)
            {
                $this->repository_handler = $parameter;
            }
        }
        // If no handler was found, make the default.
        if (is_null($this->repository_handler))
        {
            $this->repository_handler = new $this->default_repository_handler();
        }
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
    public function makeRepository($name, $repository_class, array $params = [])
    {
        return $this->repository_handler->make($name, $repository_class, $params);
    }

    /**
     * Gets a repository.
     * @param $name
     * @return RepositoryContract
     * @TODO Make this function protected.
     */
    public function getRepository($name)
    {
        return $this->repository_handler->get($name);
    }

    /**
     * Determines if a repository has been made.
     * @param $name
     * @return bool
     */
    public function hasRepository($name)
    {
        return $this->repository_handler->has($name);
    }
}