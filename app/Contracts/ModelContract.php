<?php namespace App\Contracts;

/**
 * A contract for Model objects that handle data within an application.
 * @package App\Contracts
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
interface ModelContract {

    /**
     * Gets the value of a Model attribute.
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * Gets an array of the model attributes.
     *
     * Keys will be set to the attribute names and the values set
     * to the attribute values.
     * @return array
     */
    public function getAttributes();

    /**
     * Sets the value of a model attribute.
     * @param $attribute
     * @param $value
     * @throws \InvalidArgumentException
     */
    public function setAttribute($attribute, $value);

    /**
     * Gets the name of the database table that stores the model.
     * @return string
     */
    public function table();

    /**
     * Populates the attributes of a model with data from an array.
     * @param array $data
     * @return $this
     */
    public function fill(array $data);

}