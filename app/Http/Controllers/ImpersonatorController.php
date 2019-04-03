<?php

namespace App\Http\Controllers;

use Auth, Session;
use Illuminate\Http\Request;
use App\User;

class ImpersonatorController extends Controller
{
	public function impersonate(Request $request, $user_id)
	{
		# Check if user is logged in
		if( !Auth::check() ) {
			abort(403);
		}

		$current = Auth::user();

        # Check if current user is Admin
        # Example from Spatie Laravel Permission to check if user has admin role
        # Adjust this code with your package
        if( !$current->hasRole('admin') ) {
        	abort(403);
        }

        $user = User::findOrFail($user_id);

        $meta = array(
            'user_id'  => $current->id,
            'back_url'  => url()->previous(),
            'target_user' => $user->id
        );
        
        Session::put('impersonation', json_encode($meta));
        
        ## Redirect to User Dashboard
        return redirect()->url('/dashboard');
	}

	public function rollback()
	{
		# Check if user is logged in
		if( !Auth::check() ) {
			abort(403);
		}

		if( Session::has('impersonation') )
        {
            $s = json_decode(Session::get('impersonation'));
            if( json_last_error() === JSON_ERROR_NONE )
            {
                if( isset($s->user_id) )
                {
                    Session::forget('impersonation');
                    Auth::loginUsingId($s->user_id);
                    
                    # Redirect to back url
                    return redirect()->to($s->back_url);
                }
            }
        }
        
        return redirect()->url('/dashboard');
	}
}

?>