<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class JobApplicationDao extends BaseDao
{
    public function __construct(){
        parent::__construct("job_applications");
    }

    public function getApplicationsByJobId($job_id)
    {
        return $this->query("SELECT * FROM job_applications WHERE job_id = :job_id", ["job_id" => $job_id]);
    }

    public function getApplicationsByUserId($user_id)
    {
        return $this->query("SELECT * FROM job_applications WHERE user_id = :user_id", ["user_id" => $user_id]);
    }

    public function getApplicationById($application_id)
    {
        return $this->queryUnique("SELECT * FROM job_applications WHERE application_id = :application_id", ["application_id" => $application_id]);
    }

    public function getApplicationByUserAndJobId($user_id, $job_id)
    {
        return $this->queryUnique("SELECT * FROM job_applications WHERE user_id = :user_id AND job_id = :job_id", ["user_id" => $user_id, "job_id" => $job_id]);
    }

    public function insertApplication($application)
    {
        $this->insert($application, "job_applications");
    }

}
