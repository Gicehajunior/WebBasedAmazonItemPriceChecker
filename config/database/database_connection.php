<?php

class Database
{
    private $servername;
    private $dBName;
    private $dBUsername;
    private $dBPassword;
    public $conn;

    public function __construct($database_host, $database_name, $database_username, $database_password)
    {
        $this->servername = $database_host;
        $this->dBName = $database_name;
        $this->dBUsername = $database_username;
        $this->dBPassword = $database_password;
    }

    // get database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = mysqli_connect($this->servername, $this->dBUsername, $this->dBPassword, $this->dBName);

            if ($this->conn) {
                return $this->conn;
            } else {
                echo "Connection failed. Kindly Check your Internet Connection!";
            }
        } catch (\mysqli_sql_exception $e) {
            echo "Unable to establish connection!";
        }
    }
}
