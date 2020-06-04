<?php

namespace VaCentral\Models;

use VaCentral\Contracts\Model;
use VaCentral\Exceptions\BuilderException;

class Stat extends Model
{
    public $t; // Type
    public $e; // Event
    public $p; // Properties

    /**
     * Create a new stats update
     *
     * @param string $type
     * @param string $event
     * @param array  $props
     *
     * @throws BuilderException
     *
     * @return Stat
     */
    public static function new($type, $event, array $props = [])
    {
        if (empty($type) || empty($event)) {
            throw new BuilderException('Type and Event must be specified');
        }

        $stat = new Stat();
        $stat->t = $type;
        $stat->e = $event;
        $stat->p = $props;

        return $stat;
    }
}
