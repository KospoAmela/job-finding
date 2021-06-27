<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/JobApplicationDao.class.php";
require_once dirname(__FILE__)."/../dao/JobDao.class.php";
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/../dao/CompanyDao.class.php";

use \Firebase\JWT\JWT;

class JobApplicationService extends BaseService{
  private $JobDao;
  private $userDao;
  private $companyDao;
  public function __construct(){
      $this->dao = new JobApplicationDao();
      $this->JobDao = new JobDao();
      $this->userDao = new UserDao();
      $this->companyDao = new CompanyDao();
  }

  public function getApplicationById($id)
  {
      return $this->dao->getApplicationById($id);
  }

  public function getApplicationsByJobId($job_id)
  {
      return $this->dao->getApplicationsByJobId($job_id);
  }

  public function getApplicationsByUserId($user_id){
      $applications = $this->dao->getApplicationsByUserId($user_id);
      $finalApplications = array();
      foreach($applications as $application){

        /*{
    "application_id": "1",
    "job_id": "1",
    "user_id": "51",
    "timestamp": "2021-06-25 23:07:39"
}<br />*/
        $a['id'] = $application['application_id'];
        $job = $this->JobDao->getJobById($application['job_id']);
        $a['company'] = $this->companyDao->getCompanyById($job['company_id'])['name'];
        $a['title'] = $this->JobDao->getJobById($application['job_id'])['title'];
        $a['timestamp'] = $application['timestamp'];

        array_push($finalApplications, $a);
      }
      return $finalApplications;
  }

  public function insertApplication($job_id, $user_id){
      $application = [
          'timestamp' => date(Config::DATE_FORMAT),
          'job_id' => $job_id['job_id'],
          'user_id' => $user_id
      ];
      return $this->dao->insertApplication($application);
  }

  public function getApplicationsByCompanyId($company_id){
        $jobs = $this->JobDao->getJobsByCompanyId($company_id);
        $applications = array();
        foreach ($jobs as $job) {
          $applications += $this->dao->getApplicationsByJobId($job['id']);
        }
       $finalApplications = array();
       foreach ($applications as $application) {
         $a['id'] = $application['application_id'];
         $job = $this->JobDao->getJobById($application['job_id']);
         $a['company'] = $this->companyDao->getCompanyById($job['company_id'])['name'];
         $a['title'] = $this->JobDao->getJobById($application['job_id'])['title'];
         $a['timestamp'] = $application['timestamp'];
         $a['user'] = $this->userDao->getUserById($application['user_id'])['name'];
         array_push($finalApplications, $a);
       }
       return $finalApplications;
  }

}
 ?>
