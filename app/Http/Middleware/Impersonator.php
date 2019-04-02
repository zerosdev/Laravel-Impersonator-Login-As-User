<?php

namespace App\Http\Middleware;

use Closure, Session, Auth;

class Impersonator
{
	public function handle($request, Closure $next)
	{
		if( Session::has('impersonate') )
        {
            $s = json_decode(Session::get('impersonate'));
            if( json_last_error() === JSON_ERROR_NONE )
            {
                if( isset($s->target_user) ) {
                    Auth::onceUsingId($s->target_user);
                }
            }
        }

        return $next($request);
	}
}

?>