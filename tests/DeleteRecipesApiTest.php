<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 13/08/18
 * Time: 00:20
 */

use PHPUnit\Framework\TestCase;

class DeleteRecipesApiTest extends TestCase
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

    public function testDeleteRecipesWithoutToken()
    {
        $response = $this->http->request('DELETE', 'recipes/' . $this->recipeId);

        $this->assertEquals(401, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDeleteRecipesWithToken()
    {
        $response = $this->http->request('DELETE', 'recipes/' . $this->recipeId, [
            'headers' => ['token' => $this->token,
                'content-type' => 'application/json'
            ]
        ]);

        $this->assertEquals(202, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testDeleteRecipesWithErrorId()
    {
        $response = $this->http->request('DELETE', 'recipes/id', [
            'headers' => ['token' => $this->token,
                'content-type' => 'application/json'
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }


}