<?php
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
 ?>
