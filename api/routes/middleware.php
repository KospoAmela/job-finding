<?php

use \Firebase\JWT\JWT;

/*Filter based middleware*/
Flight::before('start', function($params, $output){
    if(Flight::request()->url == "/swagger") return TRUE;
    if(str_starts_with(Flight::request()->url, "/users/login")) return TRUE;
    try {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];
        $decoded = (array)JWT::decode($token, "JWT SECRET", array('HS256'));
        Flight::set('user', $decoded);
        return TRUE;
    } catch (\Exception $e) {
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
    die("You shall not pass");

});
?>
