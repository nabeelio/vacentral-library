<?php
/**
 * Created by IntelliJ IDEA.
 * User: nshahzad
 * Date: 12/6/17
 * Time: 10:20 PM
 */

namespace VaCentral;


use GuzzleHttp\Client;

class HttpClient
{
    private static $httpClient = null;

    /**
     * @return Client
     */
    public static function getHttpClient()
    {
        if(empty(self::$httpClient)) {
            self::$httpClient = new Client();
        }
        return self::$httpClient;
    }

    public static function setHttpClient($client)
    {
        self::$httpClient = $client;
    }

    public static function resetHttpClient()
    {
        self::$httpClient = new Client();
    }

}
