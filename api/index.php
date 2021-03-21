<?php

require_once dirname(__FILE__)."/dao/BaseDao.class.php";
require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/JobDao.class.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('userDao', 'UserDao');

Flight::route('GET /users', function(){
    $dao = new UserDao();
    $users = $dao->getAllUsers();
    Flight::json($users);
});

Flight::route('GET /users/@id', function($id){
    $dao = new UserDao();
    $user = $dao->getUserById($id);
    Flight::json($user);
});

Flight::route('POST /users', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $userDao = new UserDao();
    $user = $userDao->insertUser($data);
    print_r($data);
});

Flight::route('PUT /users/@id', function($id){
    $dao = new UserDao();
    $user = $dao->getUserById($id);

    $request = Flight::request();
    $data = $request->data->getData();

    $user = $dao->updateUser($id, $data);

});

Flight::route('/jobs', function(){
    $dao = new JobDao();
    $jobs = $dao->getAllJobs();
    Flight::json($jobs);
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
