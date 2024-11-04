<?php

namespace App\tools;

use Exception;

trait Responsetrait
{
    public function response($data , $status =200 , $msg =""){
        $data_array=['data' => $data,
            'status' => $status,
            'message' => $msg
        ];
        return response( $data_array , $status);
    }
    public function exception_response(Exception $ex){
        $this->response("Exception" , 400 ,"Exception Message" . $ex->getMessage() );
    }
}
