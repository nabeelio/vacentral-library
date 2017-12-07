<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;


class ApiRequest {

    /**
     * Create the full valid URL resource
     * @param $uri
     * @return string
     */
    public static function createUrl($uri)
    {
        return VaCentral::getVaCentralUrl() . '/' . $uri;
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
     */
    public static function request($method, $url, $options=[])
    {
        $options = array_merge([
            'body' => null,
            'auth' => false,
        ], $options);

        $headers = [];
        if($options['auth']) {
            $headers['Authorization'] = 'token:' . VaCentral::getApiKey();
        }

        $request = new Request($method, $url);
        $response = HttpClient::getHttpClient()->send($request);
        return \GuzzleHttp\json_decode($response->getBody());
    }
}
