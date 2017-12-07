<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

class VaCentral
{

    public static $apiKey;
    public static $vacUrl;
    public static $uris = [
        'airports' => '/api/v1/airports',
        'status' => '/api/v1/status',
    ];

    public static function getApiKey()
    {
        return self::$apiKey;
    }

    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @param $uri
     * @param array $params
     * @param array $query
     * @return mixed|string
     */
    public static function getUri($route, $params=[], $query=[])
    {
        $uri = self::getVaCentralUrl();
        $uri .= self::$uris[$route];

        if(!empty($params)) {
            $uri .= '/' . implode('/', $params);
        }

        if(!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        return $uri;
    }

    public static function getVaCentralUrl()
    {
        return self::$vacUrl;
    }

    public static function setVaCentralUrl($url)
    {
        self::$vacUrl = $url;
    }

    /**
     * @param $response
     * @return mixed|null
     */
    protected function parseResponse($response)
    {
        if ($response->getStatusCode() !== 200) {
            return null;
        }

        return json_decode($response->getBody());
    }

    /**
     * @param string $icao Airport to retrieve data about
     * @return mixed|null
     * @throws RequestException|ClientException|BadResponseException
     */
    public function getAirportData($icao)
    {
        $url = self::$urls['airport'] . '/' . $icao;
        $response = $this->client->get($url);
        return $this->parseResponse($response);
    }

    /**
     * Get the status of the vaCentral service
     * @return mixed|null
     * @throws RequestException|ClientException|BadResponseException
     */
    public function getStatus()
    {
        $url = self::$urls['status'];
        $response = $this->client->get($url);

        return $this->parseResponse($response);
    }

}
