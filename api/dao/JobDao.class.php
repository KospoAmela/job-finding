<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class JobDao extends BaseDao
{
    public function getJobById($job_id)
    {
        return $this->queryUnique("SELECT * FROM jobs WHERE job_id = :job_id", ["job_id" => $job_id]);
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
        $this->insert($job, "jobs");
    }
}
