<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 12/08/18
 * Time: 20:20
 */

class Responses
{
    public static function bad_request()
    {
        return JsonOutput::convert(["error" => "Bad Request"], 400);
    }
}