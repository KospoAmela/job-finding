<?php
Flight::route('GET /companies', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $companies = Flight::companyDao()->getAllCompaniesPaginated($offset, $limit);
    print_r($companies);
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
 ?>
