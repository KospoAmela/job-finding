<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \Firebase\JWT\JWT;

require_once dirname(__FILE__)."/../vendor/autoload.php";


//include all services
require_once dirname(__FILE__)."/services/UserService.class.php";
require_once dirname(__FILE__)."/services/JobService.class.php";
require_once dirname(__FILE__)."/services/TypeService.class.php";
require_once dirname(__FILE__)."/services/CategoryService.class.php";
require_once dirname(__FILE__)."/services/CompanyService.class.php";
require_once dirname(__FILE__)."/services/JobApplicationService.class.php";

//register all services
Flight::register('userService', 'UserService');
Flight::register('jobService', 'JobService');
Flight::register('companyService', 'CompanyService');
Flight::register('typeService', 'TypeService');
Flight::register('categoryService', 'CategoryService');
Flight::register('jobApplicationService', 'JobApplicationService');

//include all routes
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/UserRoutes.php";
require_once dirname(__FILE__)."/routes/JobRoutes.php";
require_once dirname(__FILE__)."/routes/TypeRoutes.php";
require_once dirname(__FILE__)."/routes/CategoryRoutes.php";
require_once dirname(__FILE__)."/routes/CompanyRoutes.php";
require_once dirname(__FILE__)."/routes/ApplicationRoutes.class.php";


Flight::route('GET /swagger', function(){
  $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
  header('Content-Type: application/json');
  echo $openapi->toJson();
});

Flight::route('GET /', function(){
  Flight::redirect('/docs');
});

//utility function for reading queries from URL
Flight::map('query', function($name, $default_value = null){
    $request = Flight::request();
    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
});

//utility function for generating jwt token
Flight::map('jwt', function($user){
  $jwt = JWT::encode(["exp" => (time() + Config::JWT_TOKEN_TIME),
  "id" => $user["id"], "r" => $user["role"]], Config::JWT_SECRET);
  return ["token" => $jwt];
});

/* error handling for our API 
Flight::map('error', function(Exception $ex){
  Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
});
*/
Flight::start();
