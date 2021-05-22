<?php

/**
 * @OA\Get(path="/categories",
 *     @OA\Response(response="200", description="List categories from database")
 * )
 */
Flight::route('GET /categories', function(){
    $search = Flight::query("search");
    Flight::json(Flight::categoryService()->getCategories($search));
});

/**
 * @OA\Get(path="/categories/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a category from database corresponding to id")
 * )
 */
Flight::route('GET /categories/@id', function($id){
    Flight::json(Flight::categoryService()->getById($id));
});

/**
 * @OA\Post(path="/categories",
 *     @OA\Response(response="200", description="Add a category to database")
 * )
 */
Flight::route('POST /admin/categories', function(){
    if(Flight::get('user')['r'] == "ADMIN"){
        throw new \Exception("Unauthorized", 403);
    }
    $category = Flight::categoryService()->add(Flight::request()->data->getData());
    Flight::json($category);
});
 ?>
