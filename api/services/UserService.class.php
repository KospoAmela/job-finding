<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/../clients/mailer.class.php";


class UserService extends BaseService
{

    public function __construct()
    {
        $this->dao=new UserDao();
    }

    public function getUsers($search, $offset, $limit)
    {
        if($search)
        {
            return $this->dao->searchUsers($search, $offset, $limit);
        }else
        {
            return $this->dao->getAllUsersPaginated($offset, $limit);
        }
    }

    public function update($id, $user)
    {
        return parent::update($id, $user);
    }

    public function getById($id)
    {
        return parent::getById($id);
    }

    public function register($user)
    {
        if(!isset($user['username'])){
            throw new \Exception("Username is required", 1);
        }

        $token = md5(random_bytes(16));

        $u = parent::add([
          'name' => $user['name'],
          'surname' => $user['surname'],
          'email' => $user['email'],
          'password' => md5($user['password']),
          'username' => $user['username'],
          'token' => $token,
          'token_created_at' => date(Config::DATE_FORMAT)
        ]);
        $message = "http://localhost/webprogramming/api/users/confirm/".$token;
        $mail = new Mailer();
        $mail->mailer($user['email'], $message, "Validation token");

        return $u;
    }

    public function confirm($token)
    {
        $user = $this->dao->getUserByToken($token);

        if(!isset($user['id'])){
          throw new \Exception("Invalid token");
        }

        $this->dao->update($user['id'], ['status' => "ACTIVE", 'token' => null, 'token_created_at' => date(Config::DATE_FORMAT)]);
    }

    public function login($data)
    {
        $user = $this->dao->getUserByUsername($data['username']);
        if(!isset($user['id'])){
            throw new \Exception("There's no account with that username", 400);
        }else if($user['status'] != "ACTIVE"){
            throw new \Exception("Your account hasn't been confirmed yet. Check you email", 400);
        }else if($user['password'] != md5($data['password'])){
            throw new \Exception("Wrong password", 400);
        }else{
            $payload = [
              "id" => $user["id"],
              "r" => $user["role"]
            ];
            $jwt = JWT::encode($payload, "JWT SECRET");
            return ["token" => $jwt];
        }
    }

    public function forgot($user)
    {
        $userDB = $this->dao->getUserByUsername($user['username']);
        if(!isset($userDB['id']))
        {
            throw new \Exception("There's no account with that username", 400);
        }

        if((strtotime(date(Config::DATE_FORMAT)) - strtotime($userDB['token_created_at'])) / 60 < 5)
        {
            throw new \Exception("Maybe you should write your password down somewhere safe. Try reseting in a few minutes.", 400);
        }
        $userDB = $this->update($userDB['id'], ['token' => md5(random_bytes(16)), 'token_created_at' => date(Config::DATE_FORMAT)]);

        $message = "Hi ".$userDB['username'].", It seems like you've forgotten your password. If you haven't made this request, ignore this email. Here's your recovery token: ".$userDB['token'];

        $mail = new Mailer();
        $mail->mailer($userDB['email'], $message, "Reset password");

  }
  public function reset($user)
  {
      $userDB = $this->dao->getUserByToken($user['token']);
      if(!isset($userDB['id']))
      {
          throw new \Exception("Invalid token", 400);
      }

      if((strtotime(date(Config::DATE_FORMAT)) - strtotime($userDB['token_created_at'])) / 60 > 30)
      {
          throw new \Exception("Token expired", 400);

      }

      $this->update($userDB['id'], ['password' => md5($user['password']), 'token' => null]);
  }
}
?>
