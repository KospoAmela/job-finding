<?php

/**
 * @OA\Get(path="/types",
 *     @OA\Response(response="200", description="List types from database")
 * )
 */
Flight::route('GET /types', function(){
    $search = Flight::query("search");
    Flight::json(Flight::typeService()->getTypes($search));
});

/**
 * @OA\Get(path="/types/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a type from database corresponding to id")
 * )
 */
Flight::route('GET /types/@id', function($id){
    $type = Flight::typeService()->getById($id);
    Flight::json($type);
});

/**
 * @OA\Post(path="/types",
 *     @OA\Response(response="200", description="Add a type to database")
 * )
 */
Flight::route('POST /types', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $type = Flight::typeService()->add($data);
    print_r($data);
});
 ?>
