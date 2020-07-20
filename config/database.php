<?php
class Database{

    // specify your own database credentials
    private $host = "beidup9jvkmiedxwn7wv-mysql.services.clever-cloud.com";
    private $db_name = "beidup9jvkmiedxwn7wv";
    private $username = "uvrcjplajbdg8pgy";
    private $password = "RJqQE6Ljbjgd2F757uu1";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>