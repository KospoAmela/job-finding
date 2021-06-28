<?php

/**
 * @OA\Get(path="/companies",
 *     @OA\Response(response="200", description="List companies from database")
 * )
 */
Flight::route('GET /companies', function(){
    /*$offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::companyService()->getCompanies($search, $offset, $limit));*/
    Flight::json(Flight::companyService()->getAllCompanies());
});

/**
 * @OA\Get(path="/companies/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a company from database corresponding to id")
 * )
 */
Flight::route('GET /user/companies', function(){
    Flight::json(Flight::companyService()->getById(Flight::get('user')['id']));
});

/**
 * @OA\Post(path="/companies/register",
 *  @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="Firma d.o.o.",	description="Name of the company" ),
 *    				 @OA\Property(property="address", required="true", type="string", example="Ulica neka br.3",	description="Address of the company" ),
 *    				 @OA\Property(property="country", required="true", type="string", example="BiH",	description="Country where company is" ),
 *    				 @OA\Property(property="city", required="true", type="string", example="Sarajevo",	description="City where company is" ),
 *             @OA\Property(property="email", required="true", type="string", example="firma@gmail.com",	description="email" ),
 *    				 @OA\Property(property="password", required="true", type="string", example="password123",	description="Password for the account" )
 *         )
 *       )
 *     ),
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
 *        @OA\RequestBody(description="Basic company info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *          				 @OA\Property(property="name", required="false", type="string", example="Firma d.o.o.",	description="Name of the company" ),
 *           				 @OA\Property(property="address", required="false", type="string", example="Ulica neka br.3",	description="Address of the company" ),
 *          				 @OA\Property(property="country", required="false", type="string", example="BiH",	description="Country where company is" ),
 *          				 @OA\Property(property="city", required="false", type="string", example="Sarajevo",	description="City where company is" ),
 *                   @OA\Property(property="email", required="false", type="string", example="firma@gmail.com",	description="email" ),
 *           				 @OA\Property(property="password", required="false", type="string", example="password123",	description="Password for the account" )
 *              )
 *             )
 *           ),
 *     @OA\Response(response="200", description="Update a company in the database")
 * )
 */
Flight::route('PUT /user/companies/', function(){
    $company = Flight::companyService()->update(Flight::get('user')['id'], Flight::request()->data->getData());
    Flight::json($company);
});

/**
 * @OA\Get(path="/companies/confirm/{token}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="token", example=1),
 *     @OA\Response(response="200", description="Activate a company account")
 * )
 */
Flight::route('GET /companies/confirm/@token', function($token){
    Flight::json(Flight::jwt(Flight::companyService()->confirm($token)));
});

/**
 * @OA\Get(path="/companies/login",
 *        @OA\RequestBody(description="Basic company info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *                @OA\Property(property="email", required="true", type="string", example="firma@gmail.com",	description="email" ),
 *           		  @OA\Property(property="password", required="true", type="string", example="password123",	description="Password for the account" )
 *             )
 *            )
 *          ),
 *     @OA\Response(response="200", description="Validate login credentials")
 * )
 */
Flight::route('POST /companies/login', function(){
    Flight::json(Flight::jwt(Flight::companyService()->login(Flight::request()->data->getData())));
});

/**
 * @OA\Get(path="/companies/forgot",
 *        @OA\RequestBody(description="Basic company info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *                @OA\Property(property="email", required="true", type="string", example="firma@gmail.com",	description="email" ),
 *              )
 *            )
 *          ),
 *     @OA\Response(response="200", description="Get recovery link for a forgotten password")
 * )
 */
Flight::route('POST /companies/forgot', function(){
    Flight::companyService()->forgot(Flight::request()->data->getData());
    Flight::json(["message" => "Recovery link has been sent to your email."]);
});

/**
 * @OA\Get(path="/companies/reset",
 *        @OA\RequestBody(description="Basic company info", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *                @OA\Property(property="token", required="true", type="string", example="3b4abe23b8e6946077cae9426f92910c",	description="Token recieved on email" ),
 *           		  @OA\Property(property="password", required="true", type="string", example="password123",	description="New password for the account" )
 *             )
 *            )
 *          ),
 *     @OA\Response(response="200", description="Reset password")
 * )
 */
Flight::route('POST /companies/reset', function(){
    Flight::json(Flight::jwt(Flight::companyService()->reset(Flight::request()->data->getData())));
});
 ?>
