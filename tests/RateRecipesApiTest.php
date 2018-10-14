<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 13/08/18
 * Time: 01:04
 */

use PHPUnit\Framework\TestCase;

class RateRecipesApiTest extends TestCase
{
    private $http;
    private $recipeId;


    public function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/hello/']);

        $recipes = $this->http->request('GET', 'recipes');
        $body = $recipes->getBody();
        $this->recipeId = json_decode($body)[0]->id;


    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function testRateRecipes()
    {
        $input = ["rate" => "4"];

        $response = $this->http->request('POST', 'recipes/' . $this->recipeId . '/rating', [
            'body' => json_encode($input),
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testRateRecipesWithErrorBody()
    {
        $input = ["rate" => "7"];

        $response = $this->http->request('POST', 'recipes/' . $this->recipeId . '/rating', [
            'body' => json_encode($input),
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }


}