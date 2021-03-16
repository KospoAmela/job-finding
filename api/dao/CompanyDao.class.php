<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class CompanyDao extends BaseDao
{
    public function getCompanyByEmail($email){
        return $this->query("SELECT * FROM companies WHERE email = :email", ["email" => $email]);
    }

    public function getCompanyById($company_id){
        return $this->query("SELECT * FROM companies WHERE company_id = :company_id", ["company_id" => $company_id]);
    }

}
