<?php
/**
 * Created by IntelliJ IDEA.
 * User: nshahzad
 * Date: 12/6/17
 * Time: 7:12 PM
 */

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use VaCentral\VaCentral;
use GuzzleHttp\Handler\MockHandler;


class VaCentralTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        //VaCentral::setVaCentralUrl('http://vacentral.dev');
    }

    protected function addMocks($mocks)
    {
        $handler = HandlerStack::create($mocks);
        $client = new GuzzleHttp\Client(['handler' => $handler]);
        \VaCentral\HttpClient::setHttpClient($client);
    }

    /**
     * URL formation
     */
    public function testGetUri()
    {
        $this->assertEquals(
            'https://api.vacentral.net/api/v1/status',
            VaCentral::getUri('status')
        );

        $this->assertEquals(
            'https://api.vacentral.net/api/v1/airports/KJFK',
            VaCentral::getUri('airports', ['KJFK'])
        );

        $this->assertEquals(
            'https://api.vacentral.net/api/v1/airports?p=1',
            VaCentral::getUri('airports', null, ['p' => 1])
        );
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
        $this->assertEquals('xyz', $response->version);
    }

    public function testAirportDataMocked()
    {
        $this->addMocks(new MockHandler([
            new Response(200, [], '{"data":{"id":"KJFK","iata":"JFK","icao":"KJFK","name":"John F Kennedy International Airport","location":"New York","country":"United States","timezone":"America\/New_York","fuel_100ll_cost":"0.0","fuel_jeta_cost":"0.0","fuel_mogas_cost":"0.0","lat":"40.63980103","lon":"-73.77890015"}}'),
            new Response(404, [], json_encode(['message' => 'Not Found']))
        ]));

        $response = \VaCentral\Airport::get('KJFK');
        $this->assertEquals('KJFK', $response->icao);

        // Expect a 404 error message
        $this->expectException(\VaCentral\HttpException::class);
        $this->expectExceptionCode(404);
        \VaCentral\Airport::get('GARBAGE');
    }

    /**
     * Check airports
     */
    public function testAirportData()
    {
        \VaCentral\HttpClient::resetHttpClient();

        $response = \VaCentral\Airport::get('KJFK');
        $this->assertEquals('KJFK', $response->icao);

        // Expect a 404 error message
        $this->expectException(\VaCentral\HttpException::class);
        $this->expectExceptionCode(404);
        \VaCentral\Airport::get('GARBAGE');
    }
}
