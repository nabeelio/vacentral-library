<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

class Airport extends ApiRequest
{
    /**
     * Get the Airport information from the vaCentral API
     * @param $icao
     * @return mixed|object
     *  [
     *      'icao' => '',
     *      'name' => '',
     *      'location' => '',
     *      'lat' => '',
     *      'lon' => '',
     *      'tz' => ''
     *  ]
     */
    public static function get($icao)
    {
        $url = VaCentral::getUri('airports', [$icao]);
        return self::request('GET', $url);
    }
}
