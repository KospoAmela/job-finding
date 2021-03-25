<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class JobDao extends BaseDao
{
    public function __construct(){
        parent::__construct("jobs");
    }
    public function getJobById($id)
    {
        return $this->queryUnique("SELECT * FROM jobs WHERE id = :id", ["id" => $id]);
    }

    public function getJobsByType($type_id)
    {
        return $this->query("SELECT * FROM jobs WHERE type_id = :type_id", ["type_id" => $type_id]);
    }

    public function getJobsByCategory($category_id)
    {
        return $this->query("SELECT * FROM jobs WHERE category_id = :category_id", ["category_id" => $category_id]);
    }

    public function updateJob($id, $job)
    {
        $this->update("jobs", $id, $job);
    }

    public function insertJob($job)
    {
        $job['posted_at']=date("Y-m-d H:i:s");
      //  'deadline' => date("Y-m-d H:i:s",mktime(23, 59, 59, 3, 29, 2021))
        $this->insert($job, "jobs");
    }

    public function getAllJobs()
    {
        return $this->getAll("jobs");
    }

    public function getAllJobsPaginated()
    {
        return $this->getAllPaginated("jobs");
    }

    public function searchJobs($search, $offset, $limit){
      return $this->query("SELECT * FROM jobs
                           WHERE title LIKE CONCAT('%', :title, '%')
                           LIMIT ${limit} OFFSET ${offset}", ["title" => $search]);
    }
}
