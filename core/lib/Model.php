<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 10/08/18
 * Time: 01:57
 */

class Model
{
    private $_connection;
    public $table;
    public $show_fields = "*";
    private static $_result;
    public $roles = [];

    public function __construct()
    {
        $db_connection = Connection::getInstance();
        $this->_connection = $db_connection->getConnection();
    }


    public function all()
    {
        $query = 'SELECT ' . $this->show_fields . ' FROM ' . $this->table;
        $this->runQuery($query);
        return $this->ConvertToArray();
    }


    public function insert(array $data)
    {
        $fields = implode(',', array_keys($data));
        $values = implode(',', array_map(array($this, 'quoteValue'), array_values($data)));
        $query = 'INSERT INTO ' . $this->table . '(' . $fields . ') ' . ' VALUES(' . $values . ')';
        if ($this->runQuery($query)) {
            return ["status" => true, "error" => ""];
        }
        return ["status" => false, "error" => "Some error happen"
        ];

    }

    public function select($where = '', $fields = '*')
    {
        $query = 'SELECT ' . $fields . ' FROM ' . $this->table
            . (($where) ? ' WHERE ' . $where : "");
        $this->runQuery($query);

        return $this->ConvertToArray();
    }

    public function update($array, $id)
    {
        $updates = [];
        if (count($array) > 0) {
            foreach ($array as $key => $value) {

                $value = mysqli_real_escape_string($this->_connection, $value); // this is dedicated to @Jon
                $value = "'$value'";
                $updates[] = "$key = $value";
            }
        }
        $implodeArray = implode(', ', $updates);
        $query = 'UPDATE ' . $this->table . ' SET ' . $implodeArray . ' WHERE id=' . $id;
        if ($this->runQuery($query)) {
            return ["status" => true, "error" => ""];
        }
        return ["status" => false, "error" => "Some error happen"
        ];
    }

    public function delete($where = '')
    {
        $query = 'DELETE from ' . $this->table . (($where) ? ' WHERE ' . $where : "");

        if ($this->runQuery($query)) {
            return ["status" => true, "error" => ""];
        }
        return ["status" => false, "error" => "Some error happen"
        ];
    }

    public function quoteValue($value)
    {
        if ($value === null) {
            $value = 'NULL';
        } else if (!is_numeric($value)) {
            $value = "'" . mysqli_real_escape_string($this->_connection, $value) . "'";
        }
        return $value;
    }

    private function runQuery($query)
    {
        if (!self::$_result = mysqli_query($this->_connection, $query)) {

            printf("Error executing the specified query " . $query . mysqli_error($this->_connection));
            return false;
        }
        return true;

    }

    private function ConvertToArray()
    {
        $output = array();
        while ($r = mysqli_fetch_assoc(self::$_result)) {
            $output[] = $r;
        }
        return $output;

    }
}