<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;


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
     * @throws HttpException
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
        try {
            $response = HttpClient::getHttpClient()->send($request, [
                'http_errors' => true
            ]);
        } catch (ClientException $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }

        return \GuzzleHttp\json_decode($response->getBody());
    }
}
