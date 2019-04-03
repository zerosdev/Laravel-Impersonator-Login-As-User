<?php

namespace App\Http\Middleware;

use Closure, Session, Auth;

class Impersonator
{
	public function handle($request, Closure $next)
	{
		if( Session::has('impersonation') )
        {
            $session = Session::get('impersonation');
            $s = json_decode($session);
            if( json_last_error() === JSON_ERROR_NONE )
            {
                if( isset($s->target_user) ) {
                    if( Auth::id() != $s->target_user )
                    {
                        Auth::loginUsingId($s->target_user);
                        Session::put('impersonation', $session);
                    }
                }
            }
        }

        return $next($request);
	}
}

?>