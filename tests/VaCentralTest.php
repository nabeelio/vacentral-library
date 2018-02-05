<?php
/**
 * Tests for vaCentral
 */

namespace tests\units\VaCentral;

use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Handler\MockHandler;

use atoum;

class VaCentral extends atoum
{
    public function setUp()
    {
        //VaCentral::setVaCentralUrl('http://vacentral.dev');
    }

    protected function addMocks($mocks)
    {
        $handler = HandlerStack::create($mocks);
        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        \VaCentral\HttpClient::setHttpClient($client);
    }

    /**
     * URL formation
     */
    public function testGetUri()
    {
        $this->string(\VaCentral\VaCentral::getUri('status'))->isEqualTo(
            'https://api.vacentral.net/api/v1/status'
        );

        $this->string(\VaCentral\VaCentral::getUri('airports', null, ['p' => 1]))
            ->isEqualTo('https://api.vacentral.net/api/v1/airports?p=1');
    }

    /**
     * Valid response
     */
    public function testApiStatus()
    {
        $this->addMocks(new MockHandler([
            new Response(200, [], json_encode(['version' => 'xyz']))
        ]));

        $response = \VaCentral\Status::get();
        $this->string('xyz')->isEqualTo($response->version);
    }

    public function testAirportDataMocked()
    {
        $this->addMocks(new MockHandler([
            new Response(200, [], '{"data":{"id":"KJFK","iata":"JFK","icao":"KJFK","name":"John F Kennedy International Airport","location":"New York","country":"United States","timezone":"America\/New_York","fuel_100ll_cost":"0.0","fuel_jeta_cost":"0.0","fuel_mogas_cost":"0.0","lat":"40.63980103","lon":"-73.77890015"}}'),
            new Response(404, [], json_encode(['message' => 'Not Found']))
        ]));

        $response = \VaCentral\Airport::get('KJFK');
        $this->string('KJFK')->isEqualTo($response->icao);

        // Expect a 404 error message
        $this->exception(function() {
            \VaCentral\Airport::get('GARBAGE');
        })->hasCode(404)->isInstanceOf(\VaCentral\HttpException::class);
    }

    /**
     * Call the actual vaCentral API
     */
    public function testAirportData()
    {
        \VaCentral\HttpClient::resetHttpClient();

        $response = \VaCentral\Airport::get('KJFK');
        $this->string('KJFK')->isEqualTo($response->icao);

        $this->exception(function () {
            \VaCentral\Airport::get('GARBAGE');
        })->hasCode(404)->isInstanceOf(\VaCentral\HttpException::class);
    }
}
