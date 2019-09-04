<?php
/**
 * Tests for vaCentral
 */

namespace tests\units\VaCentral;

use \GuzzleHttp\Client;
use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Handler\MockHandler;

use atoum;
use VaCentral\Contracts\IVaCentral;
use VaCentral\Exceptions\HttpException;

class VaCentral extends atoum
{
    /**
     * @var IVaCentral
     */
    protected $client;

    public function beforeTestMethod($method)
    {
        $this->client = new \VaCentral\VaCentral();
    }

    protected function addMocks($mocks)
    {
        $handler = HandlerStack::create($mocks);
        $client = new Client(['handler' => $handler]);
        $this->client->httpClient = $client;
    }

    /**
     * Valid response
     */
    public function testApiStatus()
    {
        $this->addMocks(new MockHandler([
            new Response(200, [], json_encode(['version' => 'xyz']))
        ]));

        $response = $this->client->getStatus();
        $this->string('xyz')->isEqualTo($response->version);
    }

    public function testAirportDataMocked()
    {
        $this->addMocks(new MockHandler([
            new Response(200, [], '{"icao":"KJFK","iata":"JFK","name":"John F Kennedy International Airport","city":"New York","country":"United States","tz":"America/New_York","lat":40.63980103,"lon":-73.77890015}'),
            new Response(404, [], json_encode(['message' => 'Not Found']))
        ]));

        $airport = $this->client->getAirport('KJFK');
        $this->string('KJFK')->isEqualTo($airport->icao);
        $this->float(40.63980103)->isEqualTo($airport->lat);
        $this->float(-73.77890015)->isEqualTo($airport->lon);

        // Expect a 404 error message
        $this->exception(function() {
            $this->client->getAirport('GARBAGE');
        })->hasCode(404)->isInstanceOf(HttpException::class);
    }

    /**
     * Call the actual vaCentral API
     */
    /*public function testAirportData()
    {
        $response = $this->client->getAirport('KJFK');
        $this->string('KJFK')->isEqualTo($response->icao);

        $this->exception(function () {
            $this->client->getAirport('GARBAGE');
        })->hasCode(404)->isInstanceOf(HttpException::class);
    }*/
}
