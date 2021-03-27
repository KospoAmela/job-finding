<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/JobDao.class.php";

class JobService extends BaseService{

    public function __construct(){
        $this->dao=new JobDao();
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
