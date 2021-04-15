<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class CompanyDao extends BaseDao
{
    public function __construct(){
        parent::__construct("companies");
    }
    public function getCompanyByEmail($email)
    {
        return $this->queryUnique("SELECT * FROM companies WHERE email = :email", ["email" => $email]);
    }

    public function getCompanyById($id)
    {
        return $this->queryUnique("SELECT * FROM companies WHERE id = :id", ["id" => $id]);
    }

    public function updateCompany($id, $company)
    {
        $this->update("companies", $id, $company);
    }

    public function insertCompany($company)
    {
        $this->insert($company, "companies");
    }

    public function getAllCompanies(){
      return $this->getAll("companies");
    }

    public function getAllCompaniesPaginated($offset = 0, $limit = 25)
    {
        return $this->getAllPaginated("companies", $offset, $limit);
    }

    public function searchCompanies($search, $offset, $limit){
      return $this->query("SELECT * FROM companies
                           WHERE name LIKE CONCAT('%', :name, '%')
                           LIMIT ${limit} OFFSET ${offset}", ["name" => $search]);
    }

    public function getCompanyByName($companyName){
        return $this->queryUnique("SELECT * FROM companies
                             WHERE name LIKE CONCAT('%', :name, '%')", ["name" => $companyName]);
    }

    public function getCompanyByToken($token){
      return $this->queryUnique("SELECT * FROM companies WHERE token = :token", ["token" => $token]);
    }
}
