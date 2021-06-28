<?php

/**
 * @OA\Get(path="/company/applications/{job_id}", tags="user",  security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", allowReserved=true, name="job_id", example=1),
 *     @OA\Parameter(type="string", in="header", allowReserved=true, name="Authorization", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjI4IiwiciI6IlVTRVIifQ.eaWexDbQyBq3P_lz5KNamnA-6roViLKAPjcuEnEBZrw"),
 *     @OA\Response(response="200", description="Get applications for job posted by the logged in company from database by job_id")
 * )
 */
Flight::route('GET /company/applications/{job_id}', function($job_id){
  $jwtUser = Flight::get('user');
  if($jwtUser['id'] != $this->JobDao->getJobById($job_id)['company_id'])
  {
      throw new \Exception("Unauthorized", 403);
  }
  Flight::json(Flight::jobApplicationService()->getApplicationsByJobId($job_id));
});

/**
 * @OA\Get(path="/user/applications", tags="user",  security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="string", in="header", allowReserved=true, name="Authorization", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjI4IiwiciI6IlVTRVIifQ.eaWexDbQyBq3P_lz5KNamnA-6roViLKAPjcuEnEBZrw"),
 *     @OA\Response(response="200", description="Get all applications made by the logged in user")
 * )
 */
Flight::route('GET /user/applications', function(){
  $jwtUser = Flight::get('user');
  if($jwtUser['r'] == "USER"){
    Flight::json(Flight::jobApplicationService()->getApplicationsByUserId(Flight::get('user')['id']));
  }else{
    throw new \Exception("Not a user", 403);

  }
});

/**
 * @OA\Get(path="/user/users/{id}", tags="user",  security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="string", in="header", allowReserved=true, name="Authorization", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjI4IiwiciI6IlVTRVIifQ.eaWexDbQyBq3P_lz5KNamnA-6roViLKAPjcuEnEBZrw"),
 *     @OA\Response(response="200", description="Get all applications made to jobs posted by logged in company")
 * )
 */
Flight::route('GET /company/applications', function(){
  $jwtUser = Flight::get('user');
  if($jwtUser['r'] == "COMPANY"){
      Flight::json(Flight::jobApplicationService()->getApplicationsByCompanyId(Flight::get('user')['id']));
  }else{
    throw new \Exception("Not a company", 403);
  }
});

/**
 * @OA\Post(path="/user/applications",
 *     @OA\Parameter(type="string", in="header", allowReserved=true, name="Authorization", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjI4IiwiciI6IlVTRVIifQ.eaWexDbQyBq3P_lz5KNamnA-6roViLKAPjcuEnEBZrw"),
 *        @OA\RequestBody(description="job id", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *      			@OA\Schema(
 *          				 @OA\Property(property="job_id", required="true", type="integer", example="1",	description="Id of the job the user is applying to" )
 *              )
 *             )
 *           ),
 *     @OA\Response(response="200", description="Add an application to the database")
 * )
 */
Flight::route('POST /user/applications', function(){
  $jwtUser = Flight::get('user');
  if($jwtUser['r'] == 'USER'){
    Flight::json(Flight::jobApplicationService()->insertApplication(Flight::request()->data->getData(), $jwtUser['id']));

  }else{
    throw new \Exception("Not a user", 403);
  }
});
?>
