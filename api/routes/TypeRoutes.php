<?php

/**
 * @OA\Get(path="/types",
 *     @OA\Response(response="200", description="List types from database")
 * )
 */
Flight::route('GET /types', function(){
    Flight::json(Flight::typeService()->getTypes());
});

/**
 * @OA\Get(path="/types/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a type from database corresponding to id")
 * )
 */
Flight::route('GET /types/@id', function($id){
    Flight::json(Flight::typeService()->getById($id));
});

/**
 * @OA\Post(path="/types",
 *     @OA\Response(response="200", description="Add a type to database")
 * )
 */
Flight::route('POST /admin/types', function(){
    if(Flight::get('user')['r'] == "ADMIN"){
        throw new \Exception("Unauthorized", 403);
    }
    $type = Flight::typeService()->add(Flight::request()->data->getData());
    Flight::json($type);
});
 ?>
