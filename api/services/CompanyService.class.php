<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CompanyDao.class.php";
require_once dirname(__FILE__)."/../clients/mailer.class.php";

class CompanyService extends BaseService{

    public function __construct(){
        $this->dao=new CompanyDao();
    }

    public function getCompanies($search, $offset, $limit){
        if($search){
            return $this->dao->searchCompanies($search, $offset, $limit);
        }else{
            return $this->dao->getAllCompaniesPaginated($offset, $limit);
        }
    }

    public function add($company){
        if(!isset($company['name'])) throw new \Exception("Name is missing", 1);
        return parent::add($company);
    }

    public function update($id, $company){
        return parent::update($id, $company);
    }

    public function getById($id){
        return parent::getById($id);
    }

    public function register($company){
        if(!isset($company['name'])){
            throw new \Exception("Name is required", 1);
        }
        $token = md5(random_bytes(16));
        $c = parent::add([
          'name' => $company['name'],
          'email' => $company['email'],
          'password' => md5($company['password']),
          'phone' => $company['phone'],
          'address' => $company['address'],
          'country' => $company['country'],
          'city' => $company['city'],
          'token' => $token,
          'token_created_at' => date(Config::DATE_FORMAT)
        ]);

        $message = "http://localhost/webprogramming/api/companies/confirm/".$token;
        $mail = new Mailer();
        $mail->mailer($company['email'], $message, "Validation token");

        return $c;
    }

    public function confirm($token){
        $company = $this->dao->getCompanyByToken($token);

        if(!isset($company['id'])){
          throw new \Exception("Invalid token");
        }

        $this->dao->update($company['id'], ['status' => "ACTIVE", 'token' => null]);
    }

    public function login($data){
        $company = $this->dao->getCompanyByEmail($data['email']);
        if(!isset($company['id'])){
            throw new \Exception("There's no account with that email", 400);
        }else if($company['status'] != "ACTIVE"){
            throw new \Exception("Your account hasn't been confirmed yet. Check you email", 400);
        }else if($company['password'] != md5($data['password'])){
            throw new \Exception("Wrong password", 400);
        }else{
            return $company;
        }
    }

    public function forgot($company)
    {
        $companyDB = $this->dao->getCompanyByEmail($company['email']);
        if(!isset($companyDB['id']))
        {
            throw new \Exception("There's no account with that email", 400);
        }

        $companyDB = $this->update($companyDB['id'], ['token' => md5(random_bytes(16)), 'token_created_at' => date(Config::DATE_FORMAT)]);

        $message = "Hi ".$companyDB['name'].", It seems like you've forgotten your password. If you haven't made this request, ignore this email. Here's your recovery token: ".$companyDB['token'];

        $mail = new Mailer();
        $mail->mailer($companyDB['email'], $message, "Reset password");

    }

    public function reset($company)
    {
        $companyDB = $this->dao->getCompanyByToken($company['token']);
        if(!isset($companyDB['id']))
        {
            throw new \Exception("Invalid token", 400);
        }

        if((strtotime(date(Config::DATE_FORMAT)) - strtotime($companyDB['token_created_at'])) / 60 > 30)
        {
            throw new \Exception("Token expired", 400);

        }

        $this->update($companyDB['id'], ['password' => md5($company['password']), 'token' => null]);
    }
}
 ?>
