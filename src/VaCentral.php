<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;

class VaCentral
{
    public static $apiKey;
    public static $vacUrl = 'https://api.vacentral.net';

    /**
     * Hold the base URLs
     * @var array
     */
    public static $uris = [
        'airports' => '/api/v1/airports',
        'status'   => '/api/v1/status',
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
     * Create the full valid URL resource
     * @param $uri
     * @return string
     */
    public static function createUrl($uri)
    {
        return VaCentral::getVaCentralUrl() . $uri;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     *  [
     *      'body' => false,
     *      'auth' => require token auth
     *  ]
     * @return mixed
     * @throws HttpException
     */
    public static function request($method, $url, $options = [])
    {
        $options = array_merge([
            'body' => null,
            'auth' => false,
        ], $options);

        $headers = [];
        if ($options['auth']) {
            $headers['Authorization'] = 'token:' . VaCentral::getApiKey();
        }

        $request = new Request($method, $url);
        try {
            $response = HttpClient::getHttpClient()->send($request, [
                'http_errors' => true
            ]);
        } catch (ClientException $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }

        return \GuzzleHttp\json_decode($response->getBody());
    }

    /**
     * @param string $route
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
}
