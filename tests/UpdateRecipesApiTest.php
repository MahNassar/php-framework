<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 12/08/18
 * Time: 22:30
 */

use PHPUnit\Framework\TestCase;

class UpdateRecipesApiTest extends TestCase
{
    private $http;
    private $token;
    private $recipeId;

    public function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/hello/']);

        $tokenReq = $this->http->request('GET', 'auth');
        $body = $tokenReq->getBody();
        $this->token = json_decode($body)->token;

        $recipes = $this->http->request('GET', 'recipes');
        $body = $recipes->getBody();
        $this->recipeId = json_decode($body)[0]->id;

    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testUpdateWithoutToken()
    {
        $input = ["name" => "test add ", "prep_time" => "30", "difficulty" => "1", "vegetarian" => 1];

        $response = $this->http->request('PUT', 'recipes/' . $this->recipeId, [
            'body' => json_encode($input),
        ]);

        $this->assertEquals(401, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testUpdateWithToken()
    {
        $input = ["name" => "dddd", "prep_time" => "30", "difficulty" => "1", "vegetarian" => 1];

        $response = $this->http->request('PUT', 'recipes/' . $this->recipeId, [
            'headers' => ['token' => $this->token,
                'content-type' => 'application/json'
            ],
            'body' => json_encode($input),
        ]);

        $this->assertEquals(202, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testUpdateWithErrorBody()
    {
        $input = ["na" => "dddd", "prep_time" => "string", "difficulty" => "1", "vegetarian" => 1];

        $response = $this->http->request('PUT', 'recipes/' . $this->recipeId, [
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