<?php

namespace VaCentral\Contracts;

class Model
{
    /**
     * Create a new instance of the model
     *
     * @param array $fields
     *
     * @return mixed
     */
    public static function create($fields = [])
    {
        $instance = new static();
        foreach ($fields as $name => $value) {
            $instance->{$name} = $value;
        }

        return $instance;
    }

    /**
     * Implement the __set_state() magic method
     * https://www.php.net/manual/en/language.oop5.magic.php#object.set-state
     *
     * @param $an_array
     *
     * @return mixed
     */
    public static function __set_state($an_array)
    {
        return static::create($an_array);
    }

    /**
     * Convert this class to an array (for POST, PUT, etc)
     */
    public function toArray()
    {
        return (array) $this;
    }
}
