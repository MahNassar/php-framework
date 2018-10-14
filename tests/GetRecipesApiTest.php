<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 12/08/18
 * Time: 00:11
 */

use PHPUnit\Framework\TestCase;


class GetRecipesApiTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/hello/']);
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testGetList()
    {
        $response = $this->http->request('GET', 'recipes');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

    }

    public function testGetOne()
    {
        $response = $this->http->request('GET', 'recipes/3');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGetOneWithStringId()
    {
        $response = $this->http->request('GET', 'recipes/eee');

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

}