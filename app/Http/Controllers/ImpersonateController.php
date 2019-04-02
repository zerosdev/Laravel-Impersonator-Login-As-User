<?php

namespace App\Http\Controllers;

use Auth, Session;
use Illuminate\Http\Request;
use App\User;

class ImpersonateController extends Controller
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
        if( !$current->hasRole('admin') ) {
        	abort(403);
        }

        $user = User::findOrFail($user_id);

        $meta = [
            'user_id'  => $admin->id,
            'back_url'  => url()->previous(),
            'target_user' => $user->id
        ];
        
        Session::put('impersonate', json_encode($meta));
        
        ## Redirect to User Dashboard
        return redirect()->url('/dashboard');
	}

	public function rollback()
	{
		# Check if user is logged in
		if( !Auth::check() ) {
			abort(403);
		}

		if( Session::has('impersonate') )
        {
            $s = json_decode(Session::get('impersonate'));
            if( json_last_error() === JSON_ERROR_NONE )
            {
                if( isset($s->user_id) )
                {
                    Session::forget('impersonate');
                    Auth::loginUsingId($s->user_id);
                    
                    # Redirect to back url
                    return redirect()->to($s->back_url);
                }
            }
        }
        
        # Redirect to Admin dashboard
        return redirect()->url('/admin');
	}
}

?>