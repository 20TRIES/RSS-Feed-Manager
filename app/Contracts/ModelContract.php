<?php namespace App\Contracts;


interface ModelContract {

    /**
     * Gets the value of a Model attribute.
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name);

}