<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class TypeDao extends BaseDao
{
    public function __construct(){
        parent::__construct("types");
    }

    public function getTypeById($id)
    {
        return $this->queryUnique("SELECT * FROM types WHERE id = :id", ["id" => $id]);
    }

    public function insertType($type){
        $this->insert($type, "types");
    }

    public function getTypeName($id)
    {
        $type = $this->getTypeById($id);
        return $type['name_of_type'];
    }

    public function getAllTypes(){
      return $this->getAll("types");
    }

    public function searchTypes($search, $offset, $limit){
      return $this->query("SELECT * FROM types
                           WHERE name_of_type LIKE CONCAT('%', :name_of_type, '%')", ["name_of_type" => $search]);
    }
}
 ?>
