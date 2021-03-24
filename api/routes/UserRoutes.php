<<?php 
Flight::route('GET /users', function(){
    $users = Flight::userDao()->getAllUsers();
    Flight::json($users);
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
