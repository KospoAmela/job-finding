<?php

require_once dirname(__FILE__)."/../config.php";

class BaseDao
{
    private $connection;

    public function __construct()
    {
        try {
          $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
          // set the PDO error mode to exception
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    public function insert()
    {

    }

    public function query($query, $parameter)
    {
      $stmt = $this->connection->prepare($query);
      $stmt->execute($parameter);
      return $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function queryUnique($query, $parameter) //one result or nothing
    {
        $results = $this->query($query, $parameter);
        return reset($results);
    }

    public function update()
    {

    }
}
