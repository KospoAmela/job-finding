<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \Firebase\JWT\JWT;

require_once dirname(__FILE__)."/../vendor/autoload.php";

Flight::route('GET /swagger', function(){
  $openapi = @\OpenApi\scan(__DIR__."/routes");
  header('Content-Type: application/json');
  echo $openapi->toJson();
});

Flight::route('GET /', function(){
  Flight::redirect('/docs');
});

//register all services
Flight::register('userService', 'UserService');
Flight::register('jobService', 'JobService');
Flight::register('companyService', 'CompanyService');
Flight::register('typeService', 'TypeService');
Flight::register('categoryService', 'CategoryService');

//include all routes
require_once dirname(__FILE__)."/routes/UserRoutes.php";
require_once dirname(__FILE__)."/routes/JobRoutes.php";
require_once dirname(__FILE__)."/routes/TypeRoutes.php";
require_once dirname(__FILE__)."/routes/CategoryRoutes.php";
require_once dirname(__FILE__)."/routes/CompanyRoutes.php";

//utility function for reading queries from URL
Flight::map('query', function($name, $default_value = null){
    $request = Flight::request();
    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
});

Flight::start();
