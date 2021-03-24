<<?php


Flight::route('GET /users', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);

    $search = Flight::query("search");

    if($search){
        Flight::json(Flight::userDao()->searchUsers($search, $offset, $limit));
    }else{
        Flight::json(Flight::userDao()->getAllUsersPaginated($offset, $limit));
    }

});

Flight::route('GET /users/@id', function($id){
    $user = Flight::userDao()->getUserById($id);
    Flight::json($user);
});

Flight::route('POST /users', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::userDao()->insertUser($data);
    print_r($data);
});

Flight::route('PUT /users/@id', function($id){
    $user = Flight::userDao()->getUserById($id);
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::userDao()->updateUser($id, $data);
});

 ?>
