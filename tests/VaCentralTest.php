<?php
/**
 * Created by IntelliJ IDEA.
 * User: nshahzad
 * Date: 12/6/17
 * Time: 7:12 PM
 */

use VaCentral;

class VaCentralTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        VaCentral::setVaCentralUrl('http://vacentral.dev');
    }

    public function testGetUri()
    {
        $this->assertEqual(
            'http://vacentral.net/api/v1/status',
            VaCentral::getUri('status')
        );
    }
}
