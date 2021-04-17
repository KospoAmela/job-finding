<?php

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
          'password' => $company['password'],
          'phone' => $company['phone'],
          'address' => $company['address'],
          'country' => $company['country'],
          'city' => $company['city'],
          'token' => $token
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

        $this->dao->update($company['id'], ['status' => "ACTIVE"]);

        //now send email
    }
}
 ?>
