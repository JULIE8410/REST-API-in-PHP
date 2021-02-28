<?php

class RestClient    {


    static function call($method, $callData)  {

            //Reference: https://stackoverflow.com/questions/5647461/how-do-i-send-a-post-request-with-php

            
            $requestHeader = array('requesttype' => $method);
            
            $data = array_merge($requestHeader,$callData);                    
            
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json\r\n",
                    'method'  => $method,
                    'content' => json_encode($data)
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents(API_URL, false, $context);

            return $result;

        }
        
        
        

    }


?>