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
            throw new \Exception("Name is required", 1);
        }
    }
}
 ?>
