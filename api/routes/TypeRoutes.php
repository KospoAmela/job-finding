<?php


Flight::route('GET /types', function(){
    $search = Flight::query("search");
    Flight::json(Flight::typeService()->getTypes($search));
});

Flight::route('GET /types/@id', function($id){
    $type = Flight::typeService()->getById($id);
    Flight::json($type);
});

Flight::route('POST /types', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $type = Flight::typeService()->add($data);
    print_r($data);
});
 ?>
