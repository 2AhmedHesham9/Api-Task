<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Validator;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;

class UserController extends Controller
{
    use GeneralTrait;
    public function login(Request $request){
        //validation
        try{
            $rules = [
                "email" => "required|exists:users,email",
                "password" => "required"
                //|exists:admins,password
            ];
            $validator = Validator::make ($request->all(),$rules) ;
            if($validator->fails ()) {
            $code = $this->returnCodeAccordingToInput ($validator);
            return $this->returnValidationError ($code, $validator);

            }

            //login

            $credentials = $request->only(['email', 'password']);
            $token=Auth::guard('user-api')->attempt($credentials);


            if(!$token) {
                return $this->returnError('E001','data enterd in invalid');
            }

            $user=Auth::guard('user-api')->user();
            $user->api_token=$token;
            //return token and data
            return $this->returnData('User',$user,'your Data');

        }
        catch(\Exception $ex) {
        return $this->returnError($ex->getCode(),$ex->getMessage());
                }
            }

}
