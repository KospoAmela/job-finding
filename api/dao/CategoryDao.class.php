<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class CategoryDao extends BaseDao
{
    public function __construct(){
        parent::__construct("categories");
    }

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

    public function getAllCategories(){
      return $this->getAll("categories");
    }

    public function searchCategories($search){
      return $this->query("SELECT * FROM categories
                           WHERE name_of_category LIKE CONCAT('%', :name_of_category, '%')", ["name_of_category" => $search]);
    }
}
