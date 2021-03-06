<?php

require_once dirname(__FILE__)."/BaseDao.class.php";
class UserDao extends BaseDao
{
    public function __construct(){
        parent::__construct("users");
    }

    public function getUserByEmail($email)
    {
        return $this->queryUnique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }

    public function getUserByUsername($username)
    {
        return $this->queryUnique("SELECT * FROM users WHERE username = :username", ["username" => $username]);
    }

    public function getUserById($id)
    {
        return $this->queryUnique("SELECT * FROM users WHERE id = :id", ["id" => $id]);
    }

    public function insertUser($user)
    {
      return $this->insert($user, "users");
    }

    public function updateUser($id, $user)
    {
      return $this->update("users", $id, $user);
    }

    public function getAllUsers(){
      return $this->getAll("users");
    }

    public function getAllUsersPaginated($offset, $limit){
      return $this->getAllPaginated("users", $offset, $limit);
    }

    public function searchUsers($search, $offset, $limit){
      return $this->query("SELECT * FROM users
                           WHERE username LIKE CONCAT('%', :username, '%')
                           LIMIT ${limit} OFFSET ${offset}", ["username" => $search]);
    }

    public function getUserByToken($token){
      return $this->queryUnique("SELECT * FROM users WHERE token = :token", ["token" => $token]);
    }
  }
