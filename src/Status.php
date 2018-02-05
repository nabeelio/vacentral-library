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
class Status extends VaCentral
{
    /**
     * @return mixed
     * @throws \VaCentral\HttpException
     * @throws
     */
    public static function get()
    {
        return self::request('GET', VaCentral::getUri('status'));
    }
}
