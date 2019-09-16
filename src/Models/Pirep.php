<?php

namespace VaCentral\Models;

use VaCentral\Contracts\Model;

class Pirep extends Model
{
    public $id;
    public $email;
    public $airline_code;
    public $aircraft_id;
    public $flight_number;
    public $dpt_airport_id;
    public $arr_airport_id;
    public $distance;
    public $block_time;
    public $block_fuel;
    public $route;
    public $score;
    public $source;
    public $source_name;
    public $flight_type;
    public $block_off_time;

    /**
     * @var DateTime When the flight ended, optional
     */
    public $block_on_time;

    /**
     * @var DateTime When the PIREP was submitted
     */
    public $submitted_at;

    /**
     * @var string Link to the PIREP
     */
    public $pirep_link;

    /**
     * Create a return the request body
     */
    public function getRequestBody(): array
    {
        $res = [];
        $res['id'] = $this->id;
        $res['uid'] = $this->email;

        return $res;
    }
}
