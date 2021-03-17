<?php

require_once dirname(__FILE__)."/BaseDao.class.php";
class UserDao extends BaseDao
{
    public function getUserByEmail($email)
    {
        return $this->queryUnique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }

    public function getUserById($user_id)
    {
        return $this->queryUnique("SELECT * FROM users WHERE user_id = :user_id", ["user_id" => $user_id]);
    }

    public function insertUser($user)
    {
      $sql = "INSERT INTO users (name, surname, email, password, username) VALUES (:name, :surname, :email, :password, :username)";
      $stmt= $this->connection->prepare($sql);
      $stmt->execute($user);
    }

    public function updateUser($id, $user)
    {
      $this->update("users", $id, $user);
    }
  }
