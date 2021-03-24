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

Flight::register('userDao', 'UserDao');
Flight::register('jobDao', 'JobDao');
Flight::register('typeDao', 'TypeDao');
Flight::register('categoryDao', 'CategoryDao');
Flight::register('companyDao', 'CompanyDao');

require_once dirname(__FILE__)."/routes/UserRoutes.php";
require_once dirname(__FILE__)."/routes/JobRoutes.php";
require_once dirname(__FILE__)."/routes/TypeRoutes.php";
require_once dirname(__FILE__)."/routes/CategoryRoutes.php";
require_once dirname(__FILE__)."/routes/CompanyRoutes.php";

Flight::start();

 ?>
