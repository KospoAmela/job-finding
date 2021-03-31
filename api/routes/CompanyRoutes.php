<?php
Flight::route('GET /companies', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::companyService()->getCompanies($search, $offset, $limit));
});

Flight::route('GET /companies/@id', function($id){
    $companyService = new CompanyService();
    $company = $companyService->getById($id);
    Flight::json($company);
});

Flight::route('POST /companies', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $company = Flight::companyService()->add($data);
    Flight::json($data);
});

Flight::route('PUT /companies/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();
    $company = Flight::companyService()->update($id, $data);
    Flight::json($data);
});
 ?>
