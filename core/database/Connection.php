<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 11/08/18
 * Time: 03:01
 */

class Connection
{
    private $_connection;
    private static $_instance; //The single instance
    private $_host;
    private $_username;
    private $_password;
    private $_database;

    /**
     * Get an instance of the Database
     * and connection
     */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $this->_host = DB_HOST;
        $this->_database = DB_NAME;
        $this->_username = DB_ROOT;
        $this->_password = DB_PASSWORD;

        $this->_connection = new mysqli($this->_host, $this->_username,
            $this->_password, $this->_database);

        // Error handling
        if (mysqli_connect_error()) {
            printf("Failed to conencto to MySQL: %s", mysqli_connect_error());
            exit();
        }
    }

    public function getConnection()
    {
        return $this->_connection;
    }

}
