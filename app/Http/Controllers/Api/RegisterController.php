<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Notifications\RegisterNotify;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Api\ValidatorController;

class RegisterController extends Controller
{
    public function register(Request $request){
        $data=$request->all();
        $rules=[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ];
        $validate= $this->validate_data($data,$rules);
        if($validate['response']){
            $password=$data['password'];
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
    
            $data['name']=$user->name;
            $data['email']=$user->email;
            $data['password']=$password;
            Notification::route('mail',$user->email)->notify(new RegisterNotify($data));
            $user_role = Role::where(['name' => 'User','guard_name'=>'api'])->first();
            $user->assignRole($user_role);
    
            $success['token']=  $user->createToken('MyApp')->accessToken;
            $success['name']=  $user->name;
    
            return response()->json($success, 'User register successfully.');
        }
        else{
            return response()->json(['message',$validate]);
        }

    }

    public function validate_data($data , $rules){
        $common_ctrl = new ValidatorController();
        return $common_ctrl->validator($data,$rules);
    }
     
   
}
