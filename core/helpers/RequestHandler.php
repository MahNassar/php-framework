<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 11/08/18
 * Time: 05:51
 */

class RequestHandler
{

    public static function get_request_body()
    {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
        return $input;
    }
}