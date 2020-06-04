<?php

namespace VaCentral\Contracts;

use VaCentral\Exceptions\BuilderException;

abstract class Builder
{
    protected $class;
    protected $requiredFields = [];
    protected $values = [];

    /**
     * The class that this Builder builds
     *
     * @return string
     */
    abstract protected function getClass(): string;

    /**
     * Build and return an instance of the class
     *
     * @throws BuilderException
     */
    public function build()
    {
        foreach ($this->requiredFields as $field) {
            if (!array_key_exists($field, $this->values)) {
                throw new BuilderException('Value for '.$field.' is missing');
            }

            if ($this->values[$field] === '' || $this->values[$field] === null) {
                throw new BuilderException('Value for '.$field.' cannot be blank');
            }
        }

        $klass = new ($this->getClass())();
        foreach($this->values as $key => $value) {
            $klass->{$key} = $value;
        }

        return $klass;
    }
}
