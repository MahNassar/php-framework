<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 12/08/18
 * Time: 21:53
 */

use PHPUnit\Framework\TestCase;


class AddRecipesApiTest extends TestCase
{
    private $http;
    private $token;

    public function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/hello/']);
        $tokenReq = $this->http->request('GET', 'auth');
        $body = $tokenReq->getBody();
        $this->token = json_decode($body)->token;


    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testAddRecipeWithoutToken()
    {
        $input = ["name" => "test add ", "prep_time" => "30", "difficulty" => "1", "vegetarian" => 1];

        $response = $this->http->request('POST', 'recipes', [
            'body' => json_encode($input),
        ]);

        $this->assertEquals(401, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

    }

    public function testAddRecipeWithToken()
    {
        $input = ["name" => "test add", "prep_time" => "30", "difficulty" => "1", "vegetarian" => 1];
        $response = $this->http->request('POST', 'recipes', [
            'headers' => ['token' => $this->token,
                'content-type' => 'application/json'
            ],
            'body' => json_encode($input),
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

    }

    public function testAddRecipeWithErrorBody()
    {
        $input = ["na" => "test add", "prep_time" => "string", "difficulty" => "6", "vegetarian" => 4];
        $response = $this->http->request('POST', 'recipes', [
            'headers' => ['token' => $this->token,
                'content-type' => 'application/json'
            ],
            'body' => json_encode($input),
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }


}