<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/JobDao.class.php";
require_once dirname(__FILE__)."/../dao/CompanyDao.class.php";
require_once dirname(__FILE__)."/../dao/TypeDao.class.php";
require_once dirname(__FILE__)."/../dao/CategoryDao.class.php";

class JobService extends BaseService{
    private $companyDao;
    private $typeDao;
    private $categoryDao;

    public function __construct(){
        $this->dao=new JobDao();
        $this->typeDao = new TypeDao();
        $this->categoryDao = new CategoryDao();
        $this->companyDao = new CompanyDao();
    }

    public function getJobs($search, $offset, $limit){
        if($search){
            return $this->dao->searchJobs($search, $offset, $limit);
        }else{
            return $this->dao->getAllJobsPaginated($offset, $limit);
        }
    }
}

 ?>
