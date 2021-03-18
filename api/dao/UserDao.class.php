<?php

require_once dirname(__FILE__)."/BaseDao.class.php";
class UserDao extends BaseDao
{
    public function getUserByEmail($email)
    {
        return $this->queryUnique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }

    public function getUserById($id)
    {
        return $this->queryUnique("SELECT * FROM users WHERE id = :id", ["id" => $id]);
    }

    public function insertUser($user)
    {
      $this->insert($user, "users");
    }

    public function updateUser($id, $user)
    {
      $this->update("users", $id, $user);
    }
  }
