<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

/**
 * Return the status from the vaCentral server
 * Class Status
 * @package VaCentral
 */
class Status extends ApiRequest
{
    /**
     * @return mixed
     * @throws
     */
    public static function get()
    {
        return self::request('GET', VaCentral::getUri('status'));
    }
}
