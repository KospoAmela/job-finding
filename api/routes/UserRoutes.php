<<?php


Flight::route('GET /users', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::userService()->getUsers($search, $offset, $limit));
});

Flight::route('GET /users/@id', function($id){
    $userService = new UserService();
    $user = $userService->getById($id);
    Flight::json($user);
});

Flight::route('POST /users', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::userService()->add($data);
    Flight::json($data);
});

Flight::route('PUT /users/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::userService()->update($id, $data);
    Flight::json($user);
});

 ?>
