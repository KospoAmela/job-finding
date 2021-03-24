<?php
Flight::route('GET /categories', function(){
    $categories = Flight::categoryDao()->getAllCategories();
    Flight::json($categories);
});

Flight::route('GET /categories/@id', function($id){
    $category = Flight::categoryDao()->getCategoryById($id);
    Flight::json($category);
});

Flight::route('POST /categories', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $category = Flight::categoryDao()->insertCategory($data);
    print_r($data);
});
 ?>
