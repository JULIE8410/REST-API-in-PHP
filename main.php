<?php

require_once('inc/config.inc.php');

require_once('inc/Entities/Customer.class.php');

require_once('inc/Utilities/RestClient.class.php');
require_once('inc/Utilities/Page.class.php');
require_once('inc/Utilities/CustomerConverter.class.php');

if (!empty($_GET))    {
    if ($_GET["action"] == "delete")  {
        RestClient::call("DELETE", array("CustomerID"=>$_GET['id']));
        
    }

    if ($_GET["action"] == "edit")  {
        $jsonEC = json_decode(RestClient::call("GET", array("CustomerID" => $_GET['id'])));
        
        $ec = new Customer();
        $ec->setCustomerID($jsonEC->CustomerID);
        $ec->setName($jsonEC->Name);
        $ec->setAddress($jsonEC->Address);
        $ec->setCity($jsonEC->City);
        

    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["action"]) && $_POST["action"] == "edit")    {
        $editCustomer = array(
            "CustomerID" => $_POST['id'],
            "Name" => $_POST['name'],
            "Address" => $_POST['address'],
            "City" => $_POST['city']
        );
        RestClient::call("PUT", $editCustomer);

        
    } else {
 
        $newCustomer = array(
            "Name" => $_POST['name'],
            "Address" => $_POST['address'],
            "City" => $_POST['city']
        );
        
         $result = RestClient::call("POST", $newCustomer);
         echo "Customer(No. $result) has been added to the database";
        
    }
}

$jsonCustomers = json_decode(RestClient::call("GET", array()));

$customers = CustomerConverter::convertToCustomerClass($jsonCustomers);


Page::$title = "Lab 10 - Hyeonju Kim - 300316734";
Page::header();
Page::listCustomers($customers);

if(isset($_GET['action']) && $_GET['action'] == "edit"){

        Page::editCustomer($ec);
      

    } else {
        Page::addCustomer();
    }

Page::footer();