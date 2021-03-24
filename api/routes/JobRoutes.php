<?php
Flight::route('GET /jobs', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $jobs = Flight::jobDao()->getAllJobsPaginated($offset, $limit);
    print_r($jobs);
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
