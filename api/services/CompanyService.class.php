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
}
 ?>
