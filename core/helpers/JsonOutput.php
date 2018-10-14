<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 10/08/18
 * Time: 02:41
 */

class JsonOutput
{
    public static function convert($array, $response_code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($response_code);
        return json_encode($array);

    }

}