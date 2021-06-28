<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * @OA\Get(path="/admin/users", security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="string", in="header", allowReserved=true, name="Authorization", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjI4IiwiciI6IlVTRVIifQ.eaWexDbQyBq3P_lz5KNamnA-6roViLKAPjcuEnEBZrw"),
 *     @OA\Response(response="200", description="List users from database")
 * )
 */
Flight::route('GET /admin/users', function(){
    $headers = apache_request_headers();
    //$headers['Authentication'] = "lkdjgjdlkgjdslkgj";
    $token = $headers['Authorization'];
    try {
        $decoded = (array)JWT::decode($token, "JWT SECRET", array('HS256'));
        if(Flight::get('user')['r'] == "ADMIN"){
            $offset = Flight::query("offset", 0);
            $limit = Flight::query("limit", 30);
            $search = Flight::query("search");
            Flight::json(Flight::userService()->getUsers($search, $offset, $limit));
        }else{
            Flight::json(["message" => "Unauthorized access."], 401);
        }
    } catch (\Exception $e) {
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }

});

/**
 * @OA\Get(path="/user/users/{id}", tags="user",  security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", allowReserved=true, name="id", example=1),
 *     @OA\Parameter(type="string", in="header", allowReserved=true, name="Authorization", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjI4IiwiciI6IlVTRVIifQ.eaWexDbQyBq3P_lz5KNamnA-6roViLKAPjcuEnEBZrw"),
 *     @OA\Response(response="200", description="Get a user from database corresponding to id")
 * )
 */
Flight::route('GET /user/users', function(){
    Flight::json(Flight::userService()->getById(Flight::get('user')['id']));
});

/**
 * @OA\Post(path="/register",
 *        @OA\RequestBody(description="Basic user info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *          				 @OA\Property(property="name", required="true", type="string", example="Amela",	description="Name of the person" ),
 *           				 @OA\Property(property="surname", required="true", type="string", example="Kospo",	description="Surname of the person" ),
 *          				 @OA\Property(property="username", required="true", type="string", example="amelak1",	description="Unique username" ),
 *                   @OA\Property(property="email", required="true", type="string", example="kospoamela1@gmail.com",	description="email" ),
 *           				 @OA\Property(property="password", required="true", type="string", example="password123",	description="Password for the account" )
 *              )
 *             )
 *           ),
 *     @OA\Response(response="200", description="Add a user to database")
 * )
 */
Flight::route('POST /register', function(){
    Flight::json(Flight::jwt(Flight::userService()->register(Flight::request()->data->getData())));
});

/**
 * @OA\Put(path="/user/update",security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="string", in="header", allowReserved=true, name="Authorization", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjI4IiwiciI6IlVTRVIifQ.eaWexDbQyBq3P_lz5KNamnA-6roViLKAPjcuEnEBZrw"),
 *     @OA\Response(response="200", description="Update a user in the database corresponding to id")
 * )
 */
Flight::route('PUT /user/update', function(){
    $user = Flight::userService()->update(Flight::get('user')['id'], Flight::request()->data->getData());
    Flight::json($user);
});

/**
 * @OA\Get(path="/confirm/{token}",
 *     @OA\Parameter(@OA\Schema(type="string"), in="path", allowReserved=true, name="token", example=1),
 *     @OA\Response(response="200", description="Activate a user account")
 * )
 */
Flight::route('GET /confirm/@token', function($token){
    Flight::json(Flight::jwt(Flight::userService()->confirm($token)));
});

/**
 * @OA\Get(path="/login",
 *      @OA\RequestBody(description="Basic account info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *                   @OA\Property(property="email", required="true", type="string", example="kospoamela1@gmail.com",	description="email" ),
 *           				 @OA\Property(property="password", required="true", type="string", example="password123",	description="Password for the account" )
 *              )
 *             )
 *           ),
 *     @OA\Response(response="200", description="Validate login credentials for user or company account")
 * )
 */
Flight::route('POST /login', function(){
    try {
      $data = Flight::userCompanyService()->login(Flight::request()->data->getData());
      Flight::json(Flight::jwt($data));
    } catch (\Exception $e) {
      Flight::json(["message" => $e->getMessage()], 401);
    }
});

/**
 * @OA\Get(path="/forgot",
 *      @OA\RequestBody(description="New category info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *                   @OA\Property(property="email", required="true", type="string", example="kospoamela1@gmail.com",	description="email" )
 *              )
 *             )
 *           ),
 *     @OA\Response(response="200", description="Add a new category")
 * )
 */
Flight::route('POST /forgot', function(){
    Flight::userService()->forgot(Flight::request()->data->getData());
    Flight::json(["message" => "Recovery link has been sent to your email."]);
});

/**
 * @OA\Get(path="/users/reset",
 *      @OA\RequestBody(description="Basic account info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *                   @OA\Property(property="token", required="true", type="string", example="3b4abe23b8e6946077cae9426f92910c",	description="Token recieved on email" ),
 *           				 @OA\Property(property="password", required="true", type="string", example="password123",	description="New password for the account" )
 *              )
 *             )
 *           ),
 *     @OA\Response(response="200", description="Reset password")
 * )
 */
Flight::route('POST /reset', function(){
    Flight::json(Flight::jwt(Flight::userService()->reset(Flight::request()->data->getData())));
});
