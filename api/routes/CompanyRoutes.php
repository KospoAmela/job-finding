<?php

/**
 * @OA\Get(path="/companies",
 *     @OA\Response(response="200", description="List companies from database")
 * )
 */
Flight::route('GET /companies', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::companyService()->getCompanies($search, $offset, $limit));
});

/**
 * @OA\Get(path="/companies/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a company from database corresponding to id")
 * )
 */
Flight::route('GET /companies/@id', function($id){
    Flight::json(Flight::companyService()->getById($id));
});

/**
 * @OA\Post(path="/companies",
 *     @OA\Response(response="200", description="Add a company to database")
 * )
 */
Flight::route('POST /companies/register', function(){
    Flight::companyService()->register(Flight::request()->data->getData());
    Flight::json(["message" => "Confirmation email has been sent, please confirm your account"]);
});

/**
 * @OA\Put(path="/companies/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update a company in the database")
 * )
 */
Flight::route('PUT /companies/@id', function($id){
    $company = Flight::companyService()->update($id, Flight::request()->data->getData());
    Flight::json($company);
});

/**
 * @OA\Get(path="/companies/confirm/{token}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="token", example=1),
 *     @OA\Response(response="200", description="Activate a company account")
 * )
 */
Flight::route('GET /companies/confirm/@token', function($token){
    Flight::companyService()->confirm($token);
    Flight::json(["message" => "Your company account is activated"]);
});

/**
 * @OA\Get(path="/companies/login",
 *     @OA\Response(response="200", description="Validate login credentials")
 * )
 */
Flight::route('POST /companies/login', function(){
    Flight::json(Flight::companyService()->login(Flight::request()->data->getData()));
});

/**
 * @OA\Get(path="/companies/forgot",
 *     @OA\Response(response="200", description="Get recovery link for a forgotten password")
 * )
 */
Flight::route('POST /companies/forgot', function(){
    Flight::companyService()->forgot(Flight::request()->data->getData());
    Flight::json(["message" => "Recovery link has been sent to your email."]);
});

/**
 * @OA\Get(path="/companies/reset",
 *     @OA\Response(response="200", description="Reset password")
 * )
 */
Flight::route('POST /companies/reset', function(){
    Flight::companyService()->reset(Flight::request()->data->getData());
    Flight::json(["message" => "Your password has been changed"]);
});
 ?>
