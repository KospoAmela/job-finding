<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class CategoryDao extends BaseDao
{
    public function getCategoryById($category_id)
    {
        return $this->query("SELECT * FROM categories WHERE category_id = :category_id", ["category_id" => $category_id]);
    }

    public function insertCategory($category)
    {
        $this->insert($category, "categories");
    }

}
