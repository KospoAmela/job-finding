<<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * @OA\Get(path="/users",
 *     @OA\Response(response="200", description="List users from database")
 * )
 */
Flight::route('GET /users', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::userService()->getUsers($search, $offset, $limit));
});

/**
 * @OA\Get(path="/users/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a user from database corresponding to id")
 * )
 */
Flight::route('GET /users/@id', function($id){
    $userService = new UserService();
    $user = $userService->getById($id);
    Flight::json($user);
});

/**
 * @OA\Post(path="/users",
 *     @OA\Response(response="200", description="Add a user to database")
 * )
 */
Flight::route('POST /users/register', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    Flight::userService()->register($data);
    Flight::json(["message" => "Confirmation email has been sent, please confirm your account"]);
});

/**
 * @OA\Put(path="/users/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update a user in the database corresponding to id")
 * )
 */
Flight::route('PUT /users/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::userService()->update($id, $data);
    Flight::json($user);
});

/**
 * @OA\Get(path="/users/confirm/{token}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="token", example=1),
 *     @OA\Response(response="200", description="Activate a user account")
 * )
 */
Flight::route('GET /users/confirm/@token', function($token){
    Flight::userService()->confirm($token);
    Flight::json(["message" => "Your account is activated"]);
});


Flight::route('POST /users/login', function(){
    $data = Flight::request()->data->getData();
    Flight::userService()->login($data);
});
 ?>
