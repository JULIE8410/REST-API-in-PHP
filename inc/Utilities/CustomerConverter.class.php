<?php

class CustomerConverter {

    public static function convertToStdClass($data) {

        $stdCustomerData = array();

        if(is_array($data)){

            foreach($data as $customer){

                $jsonCustomer = new stdClass;
                $jsonCustomer->CustomerID = $customer->getCustomerID();
                $jsonCustomer->Name = $customer->getName();
                $jsonCustomer->Address = $customer->getAddress();
                $jsonCustomer->City = $customer->getCity();

                $stdCustomerData[] = $jsonCustomer;

            }


        } else if(is_object($data) && get_class($data) == "Customer") {

            $jsonCustomer = new stdClass;
            $jsonCustomer->CustomerID = $data->getCustomerID();
            $jsonCustomer->Name = $data->getName();
            $jsonCustomer->Address = $data->getAddress();
            $jsonCustomer->City = $data->getCity();

            $stdCustomerData = $jsonCustomer;
        }
        return $stdCustomerData;
    }

    public static function convertToCustomerClass($data)    {
       
        $newCustomers = array();

        if(is_array($data)){
            
            foreach($data as $jsonCustomer){

                $customer = new Customer();

                $customer->setCustomerID($jsonCustomer->CustomerID);
                $customer->setName($jsonCustomer->Name);
                $customer->setAddress($jsonCustomer->Address);
                $customer->setCity($jsonCustomer->City);

                $newCustomers[] = $customer;

            }
        } else {

             $customer = new Customer();

             $customer->setCustomerID($data->CustomerID);
             $customer->setName($data->Name);
             $customer->setAddress($data->Address);
             $customer->setCity($data->City);

             $newCustomers = $customer;
       
        }
        return $newCustomers;
    }

}