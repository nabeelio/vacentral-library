<?php

namespace VaCentral\Contracts;

abstract class Model
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
}
