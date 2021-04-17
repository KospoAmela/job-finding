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
    $companyService = new CompanyService();
    $company = $companyService->getById($id);
    Flight::json($company);
});

/**
 * @OA\Post(path="/companies",
 *     @OA\Response(response="200", description="Add a company to database")
 * )
 */
Flight::route('POST /companies/register', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    Flight::companyService()->register($data);
    Flight::json(["message" => "Confirmation email has been sent, please confirm your account"]);
});

/**
 * @OA\Put(path="/companies/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update a company in the database")
 * )
 */
Flight::route('PUT /companies/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();
    $company = Flight::companyService()->update($id, $data);
    Flight::json($data);
});


Flight::route('GET /companies/confirm/@token', function($token){
    Flight::companyService()->confirm($token);
    Flight::json(["message" => "Your company account is activated"]);
});

Flight::route('POST /companies/login', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    Flight::companyService()->login($data);
});
 ?>
