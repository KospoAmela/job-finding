<?php

require_once dirname(__FILE__)."/dao/BaseDao.class.php";
require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/JobDao.class.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('userDao', 'UserDao');
Flight::register('jobDao', 'JobDao');

Flight::route('GET /users', function(){
    $users = Flight::userDao()->getAllUsers();
    Flight::json($users);
});

Flight::route('GET /users/@id', function($id){
    $user = Flight::userDao()->getUserById($id);
    Flight::json($user);
});

Flight::route('POST /users', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::userDao()->insertUser($data);
    print_r($data);
});

Flight::route('PUT /users/@id', function($id){
    $user = Flight::userDao()->getUserById($id);
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::userDao()->updateUser($id, $data);
});

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
  $user = Flight::jobDao()->insertJob($data);
  print_r($data);
});

Flight::route('PUT /jobs/@id', function($id){
    $user = Flight::jobDao()->getJobById($id);
    $request = Flight::request();
    $data = $request->data->getData();
    $user = Flight::jobDao()->updateJob($id, $data);
});

Flight::route('/hello4', function(){
    echo 'hello world!4';
});

Flight::route('/hello5', function(){
    echo 'hello world!5';
});

Flight::route('/hello6', function(){
    echo 'hello world!6';
});

Flight::start();


 ?>
