<?php

use \Firebase\JWT\JWT;

/* middleware for regular users*/
Flight::route('/user/*', function(){
  try {
    $headers = apache_request_headers();
    $token = $headers['Authorization'];
    $user = (array)JWT::decode($token, Config::JWT_SECRET, ["HS256"]);
    if (Flight::request()->method != "GET" && $user["r"] == "USER_READ_ONLY"){
      throw new Exception("Read only user can't change anything.", 403);
    }
    Flight::set('user', $user);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

/* middleware for admin users */
Flight::route('/admin/*', function(){
  try {
    $headers = apache_request_headers();
    $token = $headers['Authorization'];
    $user = (array)JWT::decode($token, Config::JWT_SECRET, ["HS256"]);
    if ($user['r'] != "ADMIN"){
      throw new Exception("Admin access required", 403);
    }
    Flight::set('user', $user);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

/* middleware for company users*/
Flight::route('/company/*', function(){
  try {
    $headers = apache_request_headers();
    $token = $headers['Authorization'];
    $user = (array)JWT::decode($token, Config::JWT_SECRET, ["HS256"]);
    if ($user["r"] != "COMPANY"){
      throw new Exception("Regular user", 403);
    }
    Flight::set('user', $user);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});
?>
