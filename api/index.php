<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/JobDao.class.php";
require_once dirname(__FILE__)."/dao/TypeDao.class.php";
require_once dirname(__FILE__)."/dao/CategoryDao.class.php";
require_once dirname(__FILE__)."/dao/CompanyDao.class.php";
require_once dirname(__FILE__)."/services/UserService.class.php";
require_once dirname(__FILE__)."/services/JobService.class.php";
require_once dirname(__FILE__)."/services/CompanyService.class.php";
require_once dirname(__FILE__)."/services/TypeService.class.php";
require_once dirname(__FILE__)."/services/CategoryService.class.php";

Flight::register('userDao', 'UserDao');
Flight::register('jobDao', 'JobDao');
Flight::register('typeDao', 'TypeDao');
Flight::register('categoryDao', 'CategoryDao');
Flight::register('companyDao', 'CompanyDao');
Flight::register('userService', 'UserService');
Flight::register('jobService', 'JobService');
Flight::register('companyService', 'CompanyService');
Flight::register('typeService', 'TypeService');
Flight::register('categoryService', 'CategoryService');

require_once dirname(__FILE__)."/routes/UserRoutes.php";
require_once dirname(__FILE__)."/routes/JobRoutes.php";
require_once dirname(__FILE__)."/routes/TypeRoutes.php";
require_once dirname(__FILE__)."/routes/CategoryRoutes.php";
require_once dirname(__FILE__)."/routes/CompanyRoutes.php";


Flight::map('query', function($name, $default_value = null){
    $request = Flight::request();

    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;

    return $query_param;
});
Flight::start();

 ?>
