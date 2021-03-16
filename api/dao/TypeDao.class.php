<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class TypeDao extends BaseDao
{
    public function getTypeById($type_id)
    {
        return $this->query("SELECT * FROM types WHERE type_id = :type_id", ["type_id" => $type_id]);
    }
}
 ?>
