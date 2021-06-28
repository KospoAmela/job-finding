<?php
/* Swagger documentation */
/**
 * @OA\Info(title="Introduction to Web Programming Project", version="0.1")
 * @OA\OpenApi(
 *    @OA\Server(url="http://localhost/webprogramming/api/", description="Development Environment" ),
 *    @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication" )
 *)
 */


 /**
  * @OA\Get(path="/jobs",
  *     @OA\Response(response="200", description="List jobs from database")
  * )
  */
Flight::route('GET /jobs', function(){
    Flight::json(Flight::jobService()->getAllJobs());
});

/**
 * @OA\Get(path="/jobs/{id}",
 *     @OA\Parameter(type="integer", name="id", default=1, description="ID of a job from database"),
 *     @OA\Response(response="200", description="Get a job from database")
 * )
 */
Flight::route('GET /jobs/@id', function($id){
    Flight::json(Flight::jobService()->getJobById($id));
});

/**
 * @OA\Post(path="/company/jobs",
 *  @OA\RequestBody(description="Basic job info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="title", required="true", type="string", example="Need a new cashier",	description="Title of the job listing" ),
 *    				 @OA\Property(property="description", required="true", type="string", example="Need an employees for 8 hours each work day with previous experience",	description="Job description" ),
 *    				 @OA\Property(property="country", required="true", type="string", example="BiH",	description="Country of job" ),
 *    				 @OA\Property(property="city", required="true", type="string", example="Sarajevo",	description="City of job" ),
 *             @OA\Property(property="category", required="true", type="string", example="IT",	description="Job field" ),
 *    				 @OA\Property(property="type", required="true", type="string", example="Internship",	description="Type of employement" ),
 *    				 @OA\Property(property="deadline", required="true", type="string", example="12/30/2022 23:59:59",	description="Deadline to apply for a job")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Add a job to database")
 * )
 */
Flight::route('POST /company/jobs', function(){
    if(Flight::get('user')['r'] != "COMPANY"){
        throw new \Exception("Must be a company to post jobs", 403);
    }
    Flight::json(Flight::jobService()->addJob(Flight::get('user'), Flight::request()->data->getData()));
});

/**
 * @OA\Put(path="/company/jobs/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *  @OA\RequestBody(description="Basic job info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="title", required="false", type="string", example="Need a new cashier",	description="Title of the job listing" ),
 *    				 @OA\Property(property="description", required="false", type="string", example="Need an employees for 8 hours each work day with previous experience",	description="Job description" ),
 *    				 @OA\Property(property="country", required="false", type="string", example="BiH",	description="Country of job" ),
 *    				 @OA\Property(property="city", required="false", type="string", example="Sarajevo",	description="City of job" ),
 *             @OA\Property(property="category", required="false", type="string", example="IT",	description="Job field" ),
 *    				 @OA\Property(property="type", required="false", type="string", example="Internship",	description="Type of employement" ),
 *    				 @OA\Property(property="deadline", required="false", type="string", example="12/30/2022 23:59:59",	description="Deadline to apply for a job")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update a job in the database")
 * )
 */
Flight::route('PUT /company/jobs/@id', function($id){
    if(Flight::get('user')['id'] != Flight::jobService()->getById($id)['company_id']){
        throw new \Exception("Unauthorized", 403);
    }
    $job = Flight::jobService()->update($id, Flight::request()->data->getData());
    Flight::json($job);
});
?>
