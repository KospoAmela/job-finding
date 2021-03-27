<?php
Flight::route('GET /jobs', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::jobService()->getJobs($search, $offset, $limit));
});

Flight::route('GET /jobs/@id', function($id){
    $jobService = new JobService();
    $job = $jobService->getById($id);
    Flight::json($job);
});

Flight::route('POST /jobs', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $job = Flight::jobService()->add($data);
    Flight::json($data);
});

Flight::route('PUT /jobs/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();
    $job = Flight::jobService()->update($id, $data);
    Flight::json($data);
});
 ?>
