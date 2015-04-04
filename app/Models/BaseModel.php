<?php namespace App\Models;

/**
 * A base class that all models should extend.
 * @package App\Models
 * @author Marcus T <marcust261@icloud.com>
 * @since 03.04.15
 */
class BaseModel {

    use RepositoryHandlerTrait;

    /**
     * @var array An array of the model attributes.
     */
    protected $attributes = [];

    /**
     * @var array An associative array of attributes that should be cast when set.
     *            Keys should be set to the attribute names and the values should
     *            be set to the class which the attribute should be cast to. Classes
     *            used must accept the value being cast in their constructor.
     */
    protected $cast       = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        // Perform setup on traits used.
        $this->setupRepositoryHandlerTrait(func_get_args());

    }

    /**
     * Gets one of the model attributes.
     * @param string $name The name of the attribute.
     * @return mixed
     */
    public function getAttribute($name)
    {
        $this->hasAttributeOrFail($name);
        return $this->attributes[$name];
    }

    /**
     * Process an array of attributes and casts any which are "castable".
     * @param array $data
     */
    protected function processCastable(array $data)
    {
        foreach($data AS $attribute => $value)
        {
            if ($this->castable($attribute))
            {
                $data[$attribute] = $this->cast($attribute, $value);
            }
        }
    }

    /**
     * Casts a "castable" attribute to its correct class.
     * @param string $attribute The name of the attribute.
     * @param mixed $value The attribute value.
     * @return mixed The value cast to it's correct class.
     */
    protected function cast($attribute, $value)
    {
        $class = $this->cast[$attribute];
        return new $class($value);
    }

    /**
     * Determines if an attribute is "castable".
     * @param string $attribute The name of the attribute.
     * @return bool TRUE if "castable" otherwise FALSE.
     */
    protected function isCastable($attribute)
    {
        return array_key_exists($attribute, $this->castable());
    }

    /**
     * Gets the model's castable array.
     * @return array
     */
    protected function castable()
    {
        return $this->cast;
    }

    /**
     * Fills a model with an array of attributes.
     * @param array $attributes An associative array of attributes that should
     *                          be set. Keys should be set to the attribute names
     *                          and the values should be the new values of the
     *                          attributes.
     */
    public function fill(Array $attributes)
    {
        foreach ($attributes AS $name => $value)
        {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Sets the value of an attribute.
     * @param string $name The attribute name.
     * @param mixed $value The new attribute value.
     */
    public function setAttribute($name, $value)
    {
        $this->hasAttributeOrFail($name);
        if ($this->isCastable($name))
        {
            $value = $this->cast($name, $value);
        }
        $this->attributes[$name] = $value;
    }

    /**
     * Determines if a model has an attribute.
     * @param string $name The name of the attribute.
     * @return bool TRUE if the attribute exists, otherwise FALSE.
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Determines if a model has an attribute and throws an exception if
     * the attribute does not exist.
     * @param string $name The name of the attribute.
     * @throws \InvalidArgumentException Thrown if attribute does not exist.
     */
    public function hasAttributeOrFail($name)
    {
        if ( ! $this->hasAttribute($name))
        {
            throw new \InvalidArgumentException("Unknown attribute: $name");
        }
    }
}