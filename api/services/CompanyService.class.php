<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CompanyDao.class.php";

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
            throw new \Exception("Username is required", 1);
        }
        $c = parent::add([
          'name' => $company['name'],
          'email' => $company['email'],
          'password' => $company['password'],
          'phone' => $company['phone'],
          'address' => $company['address'],
          'country' => $company['country'],
          'city' => $company['city'],
          'token' => md5(random_bytes(16))
        ]);

          //send email with token

          return $c;
    }

    public function confirm($token){
        $company = $this->dao->getCompanyByToken($token);

        if(!isset($company['id'])){
          throw new \Exception("Invalid token");
        }

        $this->dao->update($user['id'], ['status' => "ACTIVE"]);

        //now send email
    }
}
 ?>
