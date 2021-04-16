<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/../clients/mailer.class.php";

class UserService extends BaseService{

    public function __construct(){
        $this->dao=new UserDao();
    }

    public function getUsers($search, $offset, $limit){
        if($search){
            return $this->dao->searchUsers($search, $offset, $limit);
        }else{
            return $this->dao->getAllUsersPaginated($offset, $limit);
        }
    }

    public function update($id, $user){
        return parent::update($id, $user);
    }

    public function getById($id){
        return parent::getById($id);
    }

    public function register($user){
        if(!isset($user['username'])){
            throw new \Exception("Username is required", 1);
        }

        $token = md5(random_bytes(16));

        $u = parent::add([
          'name' => $user['name'],
          'surname' => $user['surname'],
          'email' => $user['email'],
          'password' => $user['password'],
          'username' => $user['username'],
          'token' => $token
        ]);

        $mail = new Mailer();
        $mail->mailer($user['email'], $token, "Validation token");

        return $u;
    }

    public function confirm($token){
        $user = $this->dao->getUserByToken($token);

        if(!isset($user['id'])){
          throw new \Exception("Invalid token");
        }

        $this->dao->update($user['id'], ['status' => "ACTIVE"]);

        //now send email
    }
}
?>
