<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

class Airport extends VaCentral
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
     * @throws HttpException
     */
    public static function get($icao)
    {
        $url = self::getUri('airports', [$icao]);
        $response = self::request('GET', $url);
        if(isset($response->data)) {
            return $response->data;
        }
    }
}
