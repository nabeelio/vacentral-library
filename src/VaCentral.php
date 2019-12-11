<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use VaCentral\Contracts\IVaCentral;
use VaCentral\Exceptions\HttpException;
use VaCentral\Models\Airport;

class VaCentral implements IVaCentral
{
    public $apiKey;
    public $vacUrl = 'https://api.vacentral.net';

    public $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * Get the API key
     *
     * @return string
     */
    public function getApiKey():string
    {
        return $this->apiKey;
    }

    /**
     * Set the API key
     *
     * @param string $apiKey
     * @return VaCentral
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Get the URL to the API servier
     *
     * @return string
     */
    public function getVaCentralUrl(): string
    {
        return $this->vacUrl;
    }

    /**
     * Set the URL to the API server
     *
     * @param string $url
     *
     * @return IVaCentral
     */
    public function setVaCentralUrl($url)
    {
        $this->vacUrl = $url;
        return $this;
    }

    /**
     * Look up an airport by ICAO from the API
     *
     * @param string $icao Look up an airport by ICAO
     *
     * @throws HttpException
     *
     * @return Airport
     */
    public function getAirport($icao): Airport
    {
        $icao = strtoupper($icao);
        $response = $this->request('GET', $this->getUri('/api/airports/'.$icao));
        if (isset($response)) {
            $airport = Airport::create($response);
            return $airport;
        }
    }

    /**
     * Get a status from the API
     *
     * @throws HttpException
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->request('GET', $this->getUri('/api/status'));
    }

    /**
     * @param string $method
     * @param string $url
     * @param array  $options
     *      [
     *      'body' => false,
     *      'auth' => require token auth
     *      ]
     *
     * @throws HttpException
     *
     * @return mixed
     */
    protected function request($method, $url, $options = [])
    {
        $options = array_merge([
            'body' => null,
            'auth' => false,
        ], $options);

        $headers = [];
        if ($options['auth']) {
            $headers['Authorization'] = 'token:'.$this->apiKey;
        }

        $request = new Request($method, $url);
        try {
            $response = $this->httpClient->send($request, [
                'http_errors' => true
            ]);
        } catch (ClientException $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        } catch (GuzzleException $e) {
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
    protected function getUri($route, $params=[], $query=[])
    {
        $uri = $this->vacUrl.$route;
        if(!empty($params)) {
            $uri .= '/' . implode('/', $params);
        }

        if(!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        return $uri;
    }
}
