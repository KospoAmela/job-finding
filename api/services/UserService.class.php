<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserDao.class.php";

class UserService extends BaseService{

    public function __construct(){
        $this->dao=new UserDao();
    }

    public function getUsers($search, $offset, $limit){
        if($search){
            return $this->dao->searchUsers($search, $offset, $limit);
        }else{
            return $this->dao->getAllUsersPaginated($offset, $limit);
        }
    }
}
?>
