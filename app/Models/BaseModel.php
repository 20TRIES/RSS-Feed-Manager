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

    protected $table = NULL;

    public function __construct()
    {
        // Perform setup on traits used.
        $this->setupRepositoryHandlerTrait(func_get_args());

    }

    public function table()
    {
        if (is_null($this->table))
        {
            $table = preg_replace('/(.*\\\\)(?=[^\\\\]*\\z)/', '', get_called_class());
            return strtolower($table) . 's';
        }
        return $this->table;
    }

    public function getAttribute($name)
    {
        $this->hasAttributeOrFail($name);
        return $this->attributes[$name];
    }

    public function getAttributes()
    {
        return $this->attributes;
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
     * @return $this
     */
    public function fill(Array $attributes)
    {
        foreach ($attributes AS $name => $value)
        {
            $this->setAttribute($name, $value);
        }
        return $this;
    }

    /**
     * Sets the value of an attribute.
     * @param string $attribute The attribute name.
     * @param mixed $value The new attribute value.
     */
    public function setAttribute($attribute, $value)
    {
        $this->hasAttributeOrFail($attribute);
        if ($this->isCastable($attribute))
        {
            $value = $this->cast($attribute, $value);
        }
        $this->attributes[$attribute] = $value;
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