<?php

namespace VaCentral\Models;

use VaCentral\Contracts\Model;

class Airport extends Model
{
    public $icao;
    public $iata;
    public $name;
    public $city;
    public $country;
    public $tz;
    public $lat;
    public $lon;
}
