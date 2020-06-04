<?php
/**
 * Copyright (C) Nabeel Shahzad
 * https://github.com/nabeelio/vacentral-library
 */

namespace VaCentral;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use VaCentral\Contracts\IVaCentral;
use VaCentral\Exceptions\HttpException;
use VaCentral\Models\Airport;
use VaCentral\Models\Stat;

class VaCentral implements IVaCentral
{
    public $apiKey;
    public static $vacUrl = 'https://api.vacentral.net';

    public $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => static::$vacUrl,
        ]);
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
     * @return null|Airport
     */
    public function getAirport($icao): Airport
    {
        $icao = strtoupper($icao);
        $response = $this->request('GET', '/api/airports/'.$icao);
        if (isset($response)) {
            $airport = Airport::create($response);
            return $airport;
        }
    }

    /**
     * Post a stat to the vaCentral service
     *
     * @param Stat $stat
     *
     * @throws HttpException
     */
    public function postStat(Stat $stat): void
    {
        $body = $stat->toArray();
        $this->request('POST', '/api/stats', [
            'body' => $body,
        ]);
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
        return $this->request('GET', '/api/status');
    }

    /**
     * Recursively sort the body
     * https://stackoverflow.com/a/4501406
     *
     * @param array $body
     *
     * @return bool
     */
    protected function sort_body(&$body): bool {
        foreach ($body as &$value) {
            if (is_array($value)) $this->sort_body($value);
        }

        return ksort($body);
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
            'body'  => null,
            'auth'  => false,
            'query' => [],
            'hmac'  => 'RNxMf6SxffYDsJJGSExlwUatPBFoktuU',
        ], $options);

        // Request options for Guzzle
        $request = [
            'headers'     => [],
            'http_errors' => true,
            'query'       => $options['query'],
        ];

        if ($options['auth']) {
            $request['headers']['x-api-key'] = $this->apiKey;
            $options['hmac'] = $this->apiKey;
        }

        if (!empty($options['body']) && is_array($options['body'])) {
            $this->sort_body($options['body']);
            $request['json'] = $options['body'];
        }

        try {
            $response = $this->httpClient->request($method, $url, $request);
        } catch (ClientException $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        } catch (GuzzleException $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }

        return \GuzzleHttp\json_decode($response->getBody());
    }
}
