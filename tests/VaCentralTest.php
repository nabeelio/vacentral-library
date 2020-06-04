<?php
/**
 * Tests for vaCentral
 */

namespace Tests;

use \GuzzleHttp\Client;
use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Handler\MockHandler;

use PHPUnit\Framework\TestCase;
use VaCentral\Contracts\IVaCentral;
use VaCentral\Exceptions\HttpException;
use VaCentral\Models\Stat;
use VaCentral\VaCentral;

class VaCentralTest extends TestCase
{
    /**
     * @var IVaCentral
     */
    protected $client;

    public function setUp(): void
    {
        $this->client = new VaCentral();
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
        $this->assertEquals('xyz', $response->version);
    }

    public function testAirportDataMocked()
    {
        $this->addMocks(new MockHandler([
            new Response(200, [], '{"icao":"KJFK","iata":"JFK","name":"John F Kennedy International Airport","city":"New York","country":"United States","tz":"America/New_York","lat":40.63980103,"lon":-73.77890015}'),
            new Response(404, [], json_encode(['message' => 'Not Found']))
        ]));

        $airport = $this->client->getAirport('KJFK');
        $this->assertEquals('KJFK', $airport->icao);
        $this->assertEquals(40.63980103, $airport->lat);
        $this->assertEquals(-73.77890015, $airport->lon);

        // Expect a 404 error message
        $this->expectException(HttpException::class);
        $this->client->getAirport('GARBAGE');
    }

    public function testStatCall()
    {
        $stat = Stat::new('event', 'test-run', ['fieldA' => 'value', 'aFirstField' => 'value2']);
        $stat_array = $stat->toArray();
        $this->assertTrue(is_array($stat_array));

        $this->client->postStat($stat);
    }
}
