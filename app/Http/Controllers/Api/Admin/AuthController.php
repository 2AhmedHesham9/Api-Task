<?php

namespace App\Http\Controllers\Api\Admin;
use App\Models\Admin;
use Validator;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;

class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request){
                //validation
            try{
                $rules = [
                    "email" => "required|exists:admins,email",
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
                $token=Auth::guard('admin-api')->attempt($credentials);


                if(!$token) {
                    return $this->returnError('E001','data enterd in invalid');
                }

                $admin=Auth::guard('admin-api')->user();
                $admin->api_token=$token;
                //return token and data
                return $this->returnData('Admin',$admin,'your Data');

            }
            catch(\Exception $ex) {
            return $this->returnError($ex->getCode(),$ex->getMessage());
                    }
        }

    public function logout(Request $request){

        $token=$request->header('auth-token');
        if($token)
        {
            try{
            JWTAuth::setToken($token)->invalidate(); //logout

            }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('','Tokken invalid');
            }
            return $this->returnSuccessMessage('logout successfully');
        }
        else
        {
            return $this->returnError('E001',"Token invalid, Not Provide");
        }


    }

}
