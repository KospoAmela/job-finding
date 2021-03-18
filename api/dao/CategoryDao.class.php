<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class CategoryDao extends BaseDao
{
    public function getCategoryById($id)
    {
        return $this->queryUnique("SELECT * FROM categories WHERE id = :id", ["id" => $id]);
    }

    public function insertCategory($category)
    {
        $this->insert($category, "categories");
    }

    public function getCategoryName($id)
    {
        $category = $this->getCategoryById($id);
        return $category['name_of_category'];
    }

}
