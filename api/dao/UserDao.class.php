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
  }
