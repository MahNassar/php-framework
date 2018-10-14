<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 13/08/18
 * Time: 02:17
 */

/**
 * ======================================================
 * Config File
 * ======================================================
 * Here  can load config variables
 * to use it in application
 * --------------------------------------------------------
 * Enjoy ...
 */


$root_url = $_SERVER["HTTP_HOST"] . "/hello/";
define("ROOT_URL", $root_url);
define("DS", DIRECTORY_SEPARATOR);
define("BASE_PATH", __DIR__);


/**
 * Database config
 */

define("DB_HOST", "localhost");
define("DB_NAME", "recipes");
define("DB_ROOT", "root");
define("DB_PASSWORD", "root");