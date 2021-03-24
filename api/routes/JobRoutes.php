<?php
Flight::route('GET /jobs', function(){
    $jobs = Flight::jobDao()->getAllJobs();
    Flight::json($jobs);
});

Flight::route('GET /jobs/@id', function($id){
    $jobs = Flight::jobDao()->getJobById($id);
    Flight::json($jobs);
});

Flight::route('POST /jobs', function(){
  $request = Flight::request();
  $data = $request->data->getData();
  $job = Flight::jobDao()->insertJob($data);
  print_r($data);
});

Flight::route('PUT /jobs/@id', function($id){
    $job = Flight::jobDao()->getJobById($id);
    $request = Flight::request();
    $data = $request->data->getData();
    $job = Flight::jobDao()->updateJob($id, $data);
});
 ?>
