<?php

namespace App\Tools;

use Exception;

trait ResponseTrait
{
    public function response($data , $status = 200 , $msg = ''){
        $data_array = [
            'data' => $data,
            'status' => $status,
            'message' => $msg
        ];
        return response($data_array , $status);
    }
    public function exception_response(Exception $e){
        return $this->response('Exception' , 400 , 'Exception Message: '.$e->getMessage());
    }
}
