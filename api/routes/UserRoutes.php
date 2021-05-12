<<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 use \Firebase\JWT\JWT;

/**
 * @OA\Get(path="/users",
 *     @OA\Response(response="200", description="List users from database")
 * )
 */
Flight::route('GET /users', function(){
    $headers = apache_request_headers();
    //$headers['Authentication'] = "lkdjgjdlkgjdslkgj";
    $token = $headers['Authorization'];
    try {
        $decoded = JWT::decode($token, "JWT SECRET", array('HS256'));
    } catch (\Exception $e) {
        print_r($e); die;
    }
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::userService()->getUsers($search, $offset, $limit));
});

/**
 * @OA\Get(path="/users/{id}", tags="user", security={{"api_key":{}}},
 *     @OA\Parameter(type="integer", in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a user from database corresponding to id")
 * )
 */
Flight::route('GET /users/@id', function($id){
    $headers = apache_request_headers();
    //$headers['Authentication'] = "lkdjgjdlkgjdslkgj";
    $token = $headers['Authorization'];
    try {
        $decoded = JWT::decode($token, "JWT SECRET", array('HS256'));
    } catch (\Exception $e) {
        print_r($e); die;
    }

    Flight::json(Flight::userService()->getById($id));
});

/**
 * @OA\Post(path="/users",
 *     @OA\Response(response="200", description="Add a user to database")
 * )
 */
Flight::route('POST /users/register', function(){
    Flight::userService()->register(Flight::request()->data->getData());
    Flight::json(["message" => "Confirmation email has been sent, please confirm your account"]);
});

/**
 * @OA\Put(path="/users/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update a user in the database corresponding to id")
 * )
 */
Flight::route('PUT /users/@id', function($id){
    $user = Flight::userService()->update($id, Flight::request()->data->getData());
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

/**
 * @OA\Get(path="/users/login",
 *     @OA\Response(response="200", description="Validate login credentials")
 * )
 */
Flight::route('POST /users/login', function(){
    Flight::json(Flight::userService()->login(Flight::request()->data->getData()));
});

/**
 * @OA\Get(path="/users/forgot",
 *     @OA\Response(response="200", description="Get recovery link for a forgotten password")
 * )
 */
Flight::route('POST /users/forgot', function(){
    Flight::userService()->forgot(Flight::request()->data->getData());
    Flight::json(["message" => "Recovery link has been sent to your email."]);
});

/**
 * @OA\Get(path="/users/reset",
 *     @OA\Response(response="200", description="Reset password")
 * )
 */
Flight::route('POST /users/reset', function(){
    Flight::userService()->reset(Flight::request()->data->getData());
    Flight::json(["message" => "Your password has been changed"]);
});
