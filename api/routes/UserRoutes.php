<<?php

Flight::map('query', function($name, $default_value = null){
    $request = Flight::request();

    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;

    return $query_param;
});

Flight::route('GET /users', function(){
    $offset = Flight::query("offset", 0);

    $limit = Flight::query("limit", 30);

    print_r($offset);
    print_r($limit);

    $users = Flight::userDao()->getAllUsersPaginated($offset, $limit);
    print_r($users);
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
