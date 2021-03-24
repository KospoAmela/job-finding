<?php

require_once dirname(__FILE__)."/dao/BaseDao.class.php";
require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/JobDao.class.php";
require_once dirname(__FILE__)."/dao/TypeDao.class.php";
require_once dirname(__FILE__)."/dao/CategoryDao.class.php";
require_once dirname(__FILE__)."/dao/CompanyDao.class.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('userDao', 'UserDao');
Flight::register('jobDao', 'JobDao');
Flight::register('typeDao', 'TypeDao');
Flight::register('categoryDao', 'CategoryDao');
Flight::register('companyDao', 'CompanyDao');

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

Flight::route('GET /types', function(){
    $types = Flight::typeDao()->getAllTypes();
    Flight::json($types);
});

Flight::route('GET /types/@id', function($id){
    $type = Flight::typeDao()->getTypeById($id);
    Flight::json($type);
});

Flight::route('POST /types', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $type = Flight::typeDao()->insertType($data);
    print_r($data);
});

//

Flight::route('GET /categories', function(){
    $categories = Flight::categoryDao()->getAllCategories();
    Flight::json($categories);
});

Flight::route('GET /categories/@id', function($id){
    $category = Flight::categoryDao()->getCategoryById($id);
    Flight::json($category);
});

Flight::route('POST /categories', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $category = Flight::categoryDao()->insertCategory($data);
    print_r($data);
});

//

Flight::route('GET /companies', function(){
    $companies = Flight::companyDao()->getAllCompanies();
    Flight::json($companies);
});

Flight::route('GET /companies/@id', function($id){
    $company = Flight::companyDao()->getCompanyById($id);
    Flight::json($company);
});

Flight::route('POST /companies', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $company = Flight::companyDao()->insertCompany($data);
    print_r($data);
});

Flight::route('PUT /companies/@id', function($id){
    $company = Flight::companyDao()->getCompanyById($id);
    $request = Flight::request();
    $data = $request->data->getData();
    $company = Flight::companyDao()->updateCompany($id, $data);
});

Flight::start();


 ?>
