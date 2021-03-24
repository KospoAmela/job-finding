<?php
Flight::route('GET /types', function(){
    $types = Flight::typeDao()->getAllTypes();
    Flight::json($types);
});

Flight::route('GET /types/@id', function($id){
    $type = Flight::typeDao()->getTypeById($id);
    Flight::json($type);
});

Flight::route('POST /types', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $type = Flight::typeDao()->insertType($data);
    print_r($data);
});
 ?>
