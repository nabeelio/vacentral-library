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
        VaCentral::setVaCentralUrl('http://vacentral.dev');
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
            'http://vacentral.dev/api/v1/status',
            VaCentral::getUri('status')
        );

        $this->assertEquals(
            'http://vacentral.dev/api/v1/airports/KJFK',
            VaCentral::getUri('airports', ['KJFK'])
        );

        $this->assertEquals(
            'http://vacentral.dev/api/v1/airports?p=1',
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
}
