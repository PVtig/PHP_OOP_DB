<?php

define('SERVER', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'cars.sqlite');

class DBClass extends SQLite3
{

    private $db;

    public function __construct($db)
    {

        $this->db = $db;

        $this->open($this->db);
    }



    public function select($what, $from, $where = null, $order = null)
    {

        $sql = 'SELECT ' . $what . ' FROM ' . $from;

        if ($where != null) $sql .= ' WHERE ' . $where;
        if ($order != null) $sql .= ' ORDER BY ' . $order;

        $query = $this->query($sql);

        $data = array();
        while ($res = $query->fetchArray(1)) {
            array_push($data, $res);
        }
        return ($data);
    }



    public function insert($table, $values, $rows = null)
    {
        $insert = 'INSERT INTO ' . $table;
        if ($rows != null) {

            $numRows = count($rows);
            for ($i = 0; $i < $numRows; $i++) {
                if (is_string($rows[$i])) $rows[$i] = $rows[$i];
            }
            $rows = implode(',', $rows);
            $insert .= ' (' . $rows . ')';
        }
        $numValues = count($values);
        for ($i = 0; $i < $numValues; $i++) {
            if (is_string($values[$i])) $values[$i] = "'" . $values[$i] . "'";
        }
        $values = implode(',', $values);
        $insert .= ' VALUES (' . $values . ');';

        $ins = $this->query($insert);
        return ($ins) ? true : false;
    }



    public function delete($table, $id)
    {

        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $table . ' . id = ' . "'" . $id . "'" . '';

        $del = $this->query($sql);
        return ($del) ? true : false;
    }



    public function closeConnect()
    {
        if ($this->db) {
            if ($this->db->close()) {
                $this->db = false;
                return true;
            } else {
                return false;
            }
        }
    }
}
$db = new DBClass(DB);
// $table = 'cars';
// $rows = array('title', 'price', 'description');
// $values = array('ZAZ', '2500', 'Lorem ZAZ');
// $db->insert($table, $values, $rows);

$table = 'cars';
$id = '5';

$del = $db->delete($table, $id);
print_r($del);


echo '<pre>';
$cars = $db->select('*', 'cars');
print_r($cars);
echo '</pre>';

$db->closeConnect();
$cars = $db->select('*', 'cars');
print_r($cars);
 



// if($query)
// {
// $rows = mysql_num_rows($query);
// for($i = 0; $i < $rows; $i++) // { // $results=mysql_fetch_assoc($query); // $key=array_keys($results); // $numKeys=count($key); // for($x=0; $x < $numKeys; $x++) // { // $fetched[$i][$key[$x]]=$results[$key[$x]]; // } // } // return $fetched; // } // else // { // return false; // } // }
