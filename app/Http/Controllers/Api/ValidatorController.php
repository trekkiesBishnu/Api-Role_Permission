<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ValidatorController extends Controller
{
    public function validator($data, $rules)
    {
        
        
        $validate = Validator::make($data, $rules);
        $error_messages = $validate->errors();
        if($validate->fails()){
            return [
                'error_message' => $error_messages,
                'response' => false
            ];
        }
        else{
            return [
                'error_message' => $error_messages,
                'response' => true
            ];
        }
    }
}
