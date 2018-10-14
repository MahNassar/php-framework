<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 10/08/18
 * Time: 02:04
 */

class View
{
    //This class send the data to the page to view the information

    public function __construct()
    {
    }

    public function render($name, $data = FALSE)
    {
        if ($data != FALSE) {
            extract($data);
        }
        require(BASE_PATH . DS . "application" . DS . "views" . DS . $name . ".php");
    }
}