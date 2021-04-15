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

    public function update($id, $job){
        return parent::update($id, $job);
    }

    public function getById($id){
        return parent::getById($id);
    }

    public function addJob($job){
      //validate the input
        if(!isset($job['title'])){
            throw new \Exception("Title is required", 1);
        }
        if(!isset($job['company_name'])){
            throw new \Exception("Company name is required", 1);
        }
        if(!isset($job['type_name'])){
            throw new \Exception("Type name is required", 1);
        }
        if(!isset($job['category_name'])){
            throw new \Exception("Category name is required", 1);
        }
        //get IDs by name
        $company = $this->companyDao->getCompanyByName($job['company_name']);
        $category = $this->categoryDao->getByCategoryByName($job['category_name']);
        $type = $this->typeDao->getTypeByName($job['type_name']);

        try{
        return parent::add([
            'posted_at' => date(Config::DATE_FORMAT),
            'deadline' => $job['deadline'],
            'company_id' => $company['id'],
            'type_id' => $type['id'],
            'category_id' => $category['id'],
            'description' => $job['description'],
            'title' => $job['title'],
            'country' => $job['country'],
            'city' => $job['city']
        ]);
      }catch(\Exception $e){
          $this->dao->rollBack();
          echo $e->getMessage();
      }
    }
}

 ?>
