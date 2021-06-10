<?php

Flight::route('GET /company/applications/{job_id}', function($job_id){
  $jwtUser = Flight::get('user');
  if($jwtUser['id'] != $this->JobDao->getJobById($job_id)['company_id'])
  {
      throw new \Exception("Unauthorized", 403);
  }
  Flight::json(Flight::jobApplicationService()->getApplicationsByJobId($job_id));
});

Flight::route('GET /user/applications', function(){
  $jwtUser = Flight::get('user');
  Flight::json(Flight::jobApplicationService()->getApplicationsByUserId(Flight::get('user')['id']));
});

Flight::route('POST /user/applications/{job_id}', function($job_id){
  $jwtUser = Flight::get('user');
  Flight::json(Flight::jobApplicationService()->add($job_id, Flight::get('user')['id']));
});
?>