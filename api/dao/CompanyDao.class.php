<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class CompanyDao extends BaseDao
{
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
        returh $this->getAllPaginated("companies", $offset, $limit);
    }
}
