<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CompanyDao.class.php";
/**
 *
 */
class UserCompanyService extends BaseService
{
  private $companyDao;
  public function __construct()
  {
      $this->dao=new UserDao();
      $this->companyDao = new CompanyDao();
  }

  public function login($user)
  {
      $db_user = $this->dao->getUserByEmail($user["email"]);
      $db_company = $this->companyDao->getCompanyByEmail($user['email']);
      $finalUser = $db_user;

      if (!isset($db_user['id']) ) {
          if(isset($db_company['id'])){
            $finalUser = $db_company;
          }
        throw new Exception("User doesn't exist", 400);
      }

      if ($finalUser['status'] != 'ACTIVE') throw new Exception("Account not active", 400);

      if ($finalUser['password'] != md5($user['password'])) throw new Exception("Invalid password", 400);

      return $finalUser;
  }
}
