<?php

require_once("inc/config.inc.php");

require_once("inc/Entities/Customer.class.php");

require_once("inc/Utilities/CustomerDAO.class.php");
require_once("inc/Utilities/PDOAgent.class.php");
require_once("inc/Utilities/Page.class.php");
require_once("inc/Utilities/CustomerConverter.class.php");

CustomerDAO::initialize();

/*
CREATE  - POST
READ    - GET
UPDATE  - PUT
DELETE  - DELETE
*/

$requestData = json_decode(file_get_contents('php://input'));

switch($_SERVER["REQUEST_METHOD"]){

    case "POST": 

        $response = array();

        if(
            isset($requestData->Name) &&
            isset($requestData->Address) &&
            isset($requestData->City)
        ){
        
        $newCustomer = new Customer();
        $newCustomer->setName($requestData->Name);
        $newCustomer->setAddress($requestData->Address);
        $newCustomer->setCity($requestData->City);

        $response = CustomerDAO::createCustomer($newCustomer);

        }else{
            $response =  array("message" => "Please provide all the necessary inputs.");
        }
     
        header("Content-Type: application/json");
        echo json_encode($response);

    break;

    case "GET":

        if(isset($requestData->CustomerID)){

            $singleCustomer = CustomerDAO::getCustomer($requestData->CustomerID);
            $stdCustomer = CustomerConverter::convertToStdClass($singleCustomer);
            header("Content-Type: application/json");
            echo json_encode($stdCustomer);
            
        }else{

            $customers = CustomerDAO::getCustomers();
            $stdCustomers = CustomerConverter::convertToStdClass($customers);
            header("Content-Type: application/json");
            echo json_encode($stdCustomers);

        }

    break;

    case "PUT":
        $editCustomer = new Customer();
        $editCustomer->setCustomerID($requestData->CustomerID);
        $editCustomer->setName($requestData->Name);
        $editCustomer->setAddress($requestData->Address);
        $editCustomer->setCity($requestData->City);

        $result = CustomerDAO::updateCustomer($editCustomer);
        header("Content-Type: application/json");
        echo json_encode($result);



    break;

    case "DELETE":
        $result = CustomerDAO::deleteCustomer($requestData->CustomerID);
        header("Content-Type: application/json");
        echo json_decode($result);

    break;
    default:

    break;



}



?>