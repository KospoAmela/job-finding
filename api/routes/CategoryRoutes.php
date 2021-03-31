<?php
Flight::route('GET /categories', function(){
    $search = Flight::query("search");
    Flight::json(Flight::categoryService()->getCategories($search));
});

Flight::route('GET /categories/@id', function($id){
    $category = Flight::categoryService()->getById($id);
    Flight::json($category);
});

Flight::route('POST /categories', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $category = Flight::categoryService()->add($data);
    print_r($data);
});
 ?>
