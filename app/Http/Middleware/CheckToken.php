<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckToken
{
    use GeneralTrait;

    public function handle(Request $request, Closure $next,$guard = null)
    {
        $user = null;
        if($guard != null){

            auth()->shouldUse($guard); //shoud you user guard / table
            /*
            $token = $request->header('token');
            $request->headers->set('token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer '.$token, true);
            */
            try {
                $user = JWTAuth::parseToken()->authenticate();
                //throw an exception
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {

                    return $this->returnError('E30001', 'INVALID _TOKEN');
                } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {

                    return $this->returnError('E30001', 'EXPIRED_TOKEN');
                } else {
                    return $this->returnError('E30001', 'Token_Not_Found');
                }
            } catch (Throwable $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {

                    return $this->returnError('E30001', 'INVALID _TOKEN');
                } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {

                    return $this->returnError('E30001', 'EXPIRED_TOKEN');
                } else {
                    return $this->returnError('E30001', 'Token_Not_Found');
                }
            }

            if (!$user)
                return $this->returnError('E30001', 'Unauthenticated');
        }



        return $next($request);
    }
}
