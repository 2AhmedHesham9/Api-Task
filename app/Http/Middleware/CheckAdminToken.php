<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
class CheckAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
        {


        $user =null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch(\Exception $e) {
            if( $e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('3001','Invalid_Token');
            }
           elseif( $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
            return $this->returnError('3001','Expired_Token');
            }
            else {
                return $this->returnError('3001','Token_NotFound');
              }
            }
        catch(\Throwable $e) {
            if( $e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('3001','Invalid_Token');
            }
           elseif( $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
            return $this->returnError('3001','Expired_Token');
            }
            else {
                return $this->returnError('3001','Token_NotFound');
              }
    if(!$user) {
        return $this->returnError('3001','unauthonticated');
    }

    return $next($request);
    }
    }
}
