<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/TypeDao.class.php";


class TypeService extends BaseService{
  public function __construct(){
      $this->dao=new TypeDao();
  }

  public function getTypes($search){
      if($search){
          return $this->dao->searchType($search);
      }else{
          return $this->dao->getAllTypes();
      }
  }

  public function add($type){
      if(!isset($type['name_of_type'])) throw new \Exception("Name is missing", 1);
      return parent::add($type);
  }

  public function getById($id){
      return parent::getById($id);
  }
}
 ?>
