<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * @OA\Info(title="Webprogramming project", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(
 *       url="http://localhost/webprogramming/api/", description="Development environment"
 *   )
 * )
 */
Flight::route('GET /swagger', function(){
    $openapi =\OpenApi\scan(dirname(__FILE__)."/../routes");
    header('Content-Type: application/json');
    echo $openapi->toJson();
});
?>
