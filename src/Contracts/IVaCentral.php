<?php

namespace VaCentral\Contracts;

use VaCentral\Exceptions\HttpException;
use VaCentral\Models\Airport;

interface IVaCentral
{
    /**
     * Set the API key
     *
     * @param $apiKey
     *
     * @return IVaCentral
     */
    public function setApiKey($apiKey);

    /**
     * Set the URL to the API server
     *
     * @param string $url
     *
     * @return IVaCentral
     */
    public function setVaCentralUrl($url);

    /**
     * Get the API key
     *
     * @return string
     */
    public function getApiKey();

    /**
     * Get the URL to the API servier
     *
     * @return string
     */
    public function getVaCentralUrl();

    /**
     * Look up an airport by ICAO from the API
     *
     * @param string $icao Look up an airport by ICAO
     *
     * @throws HttpException
     *
     * @return object
     */
    public function getAirport($icao): Airport;

    /**
     * Get a status from the API
     *
     * @throws HttpException
     *
     * @return object
     */
    public function getStatus();
}
