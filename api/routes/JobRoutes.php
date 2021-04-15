<?php

/**
 * @OA\Get(path="/jobs",
 *     @OA\Response(response="200", description="List jobs from database")
 * )
 */
Flight::route('GET /jobs', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::jobService()->getJobs($search, $offset, $limit));
});

/**
 * @OA\Get(path="/jobs/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Get a job from database corresponding to id")
 * )
 */
Flight::route('GET /jobs/@id', function($id){
    $jobService = new JobService();
    $job = $jobService->getById($id);
    Flight::json($job);
});

/**
 * @OA\Post(path="/jobs",
 *     @OA\Response(response="200", description="Add a job to database")
 * )
 */
Flight::route('POST /jobs', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $job = Flight::jobService()->addJob($data);
    Flight::json($data);
});

/**
 * @OA\Put(path="/jobs/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update a job in the database")
 * )
 */
Flight::route('PUT /jobs/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();
    $job = Flight::jobService()->update($id, $data);
    Flight::json($data);
});
 ?>
