<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/JobApplicationDao.class.php";
require_once dirname(__FILE__)."/../dao/JobDao.class.php";

use \Firebase\JWT\JWT;

class JobApplicationService extends BaseService{
  private $JobDao;
  public function __construct(){
      $this->dao = new JobApplicationDao();
      $this->JobDao = new JobDao();
  }

  public function getApplicationById($id)
  {
      $this->dao->getApplicationById($id);
  }

  public function getApplicationsByJobId($job_id)
  {
      $this->dao->getApplicationsByJobId($job_id);
  }

  public function getApplicationsByUserId($user_id){
      $this->dao->getApplicationsByUserId($user_id);
  }

  public function insertApplication($job_id, $user_id){
      $application = [
          'timestamp' => date(Config::DATE_FORMAT),
          'job_id' => $job_id,
          'user_id' => $user_id
      ];
      $this->dao->insertApplication($application);
  }

  public function getApplicationsByCompanyId($company_id){
    $this->dao->getApplicationsByCompanyId($company_id);
  }

}
 ?>
