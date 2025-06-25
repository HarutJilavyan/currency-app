<?php
require_once __DIR__ . '/../configs/config.php';

class Database {

    protected $con;
    private $query;
    private $resource;
    protected $tableName;

    public function __construct() {
        $this->con = new mysqli(HOST_NAME, HOST_USERNAME, HOST_PASSWORD, 'currency');

        if ($this->con->connect_error) {
            die("Ошибка подключения: " . $this->con->connect_error);
        }
    }

    public function logAccess() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

        $stmt = $this->con->prepare("INSERT INTO access_log (ip, user_agent) VALUES (?, ?)");
        $stmt->bind_param("ss", $ip, $userAgent);
        $stmt->execute();
        $stmt->close();
    }

    public function setTableName($name) {
        $this->tableName = $name;
        return $this;
    }

    public function select() {
        $this->query = "SELECT * FROM " . $this->tableName;
        return $this;
    }

    public function where($fieldName, $operator, $value) {
        $this->query .= " WHERE " . $fieldName . $operator . "'" . $this->cleanString($value) . "'";
        return $this;
    }

    public function whereAnd($fieldName, $operator, $value) {
        $this->query .= " AND " . $fieldName . $operator . "'" . $this->cleanString($value) . "'";
        return $this;
    }

    public function whereOr($fieldName, $operator, $value) {
        $this->query .= " OR " . $fieldName . $operator . "'" . $this->cleanString($value) . "'";
        return $this;
    }

    public function orderBy($fieldName, $direction = "ASC") {
        $this->query .= " ORDER BY " . $fieldName . " " . $direction;
        return $this;
    }

    public function insert($array) {
        $fieldNames = '';
        $values = '';
        $this->query = "INSERT INTO " . $this->tableName . " ";
        foreach ($array as $key => $value) {
            $fieldNames .= ',' . $key;
            $values .= ",'" . $this->cleanString($value) . "'";
        }
        $fieldNames = ltrim($fieldNames, ',');
        $values = ltrim($values, ',');
        $this->query .= '(' . $fieldNames . ') VALUES (' . $values . ')';
        return $this;
    }

    public function update($array) {
        $this->query = "UPDATE " . $this->tableName . " SET ";
        foreach ($array as $key => $value) {
            $this->query .= $key . "='" . $this->cleanString($value) . "',";
        }
        $this->query = rtrim($this->query, ',');
        return $this;
    }

    public function delete() {
        $this->query = "DELETE FROM " . $this->tableName;
        return $this;
    }

    public function execute() {
        $this->resource = mysqli_query($this->con, $this->query);
        return $this;
    }

    public function numRows() {
        return mysqli_num_rows($this->resource);
    }

    public function fetchRow() {
        return mysqli_fetch_assoc($this->resource);
    }

    public function fetchRows() {
        $data = [];
        while ($fetch = mysqli_fetch_assoc($this->resource)) {
            $data[] = $fetch;
        }
        return $data;
    }

    public function lastInsertId() {
        return $this->con->insert_id;
    }

    public function errno() {
        return $this->con->errno;
    }

    public function cleanString($str) {
        $str = trim($str);
        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        $str = mysqli_real_escape_string($this->con, $str);
        return $str;
    }

    // Дополнительно — получить SQL-запрос для отладки
    public function getQuery() {
        return $this->query;
    }
}
