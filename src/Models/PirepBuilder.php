<?php

namespace VaCentral\Models;

use VaCentral\Contracts\Builder;

class PirepBuilder extends Builder
{
    public $requiredFields = [
        'id',
        'email',
        'airline_icao',
        'aircraft_id',
        'flight_number',
        'dpt_airport_id',
        'arr_airport_id',
        'distance',
        'block_time',
        'block_fuel',
        'route',
        'score',
        'source',
        'source_name',
        'flight_type',
        'submitted_at',
    ];

    protected function getClass(): string
    {
        return Pirep::class;
    }

    /**
     * The PIREP's ID
     *
     * @param string $value
     *
     * @return $this
     */
    public function id($value)
    {
        $this->values['id'] = $value;
        return $this;
    }

    /**
     * @param string $value The user's email
     *
     * @return $this
     */
    public function email($value)
    {
        $this->values['user_id'] = $value;
        return $this;
    }

    /**
     * The 3 character airline code (e.g, VMS)
     *
     * @param string $value
     *
     * @return $this
     */
    public function airline_code($value)
    {
        $this->values['airline_code'] = $value;
        return $this;
    }

    /**
     * The flight number
     *
     * @param string $value
     *
     * @return $this
     */
    public function flight_number($value)
    {
        $this->values['flight_number'] = $value;
        return $this;
    }

    /**
     * An identifier for the aircraft (e.g, registration or a name)
     *
     * @param string $value
     *
     * @return $this
     */
    public function aircraft_id($value)
    {
        $this->values['aircraft_id'] = $value;
        return $this;
    }

    public function submitted_at(\DateTime $value)
    {
        $this->values['submitted_at'] = $value;
        return;
    }
}
