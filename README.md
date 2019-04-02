# Laravel Impersonator: Login As User
Sometimes we (administrator/manager of website) need access to the user account to check the features on the user's side who are having problems. Even though the admin/manager has access to the database or system, in certain cases there are users who experience problems with their account and can only be checked from the related user account.

This code is useful for doing this by log into the user account without having to know the user's password. And easily return to the admin account without having to logout first.

## Basic Of Usage

1. Copy **app** folder into your project folder

2. Edit your **app/Http/Kernel.php** and add this following code to the **$middlewareGroups** property
<pre><code>protected $middlewareGroups = [
        'web' => [
            \\ Other middlewares
            \App\Http\Middleware\Impersonator::class,
        ],
        ....</code></pre>
        
3. Add this example routes to your **routes/web.php**
<pre><code>// Other routes

Route::get('/admin/impersonate/{user_id}', 'ImpersonatorController@impersonate');
Route::get('/impersonator/rollback', 'ImpersonatorController@rollback');</code></pre>

## Testing

To start impersonating user account:

You need to login to the Admin account that has **admin** role, then access https://yourdomain.com/admin/impersonate/123, where **123** is the id of target user account.
Now you are logged in as target user.

To back to the admin account:

Access https://yourdomain.com/impersonator/rollback

## Important Note

In the **app/Http/Controllers/ImpersonatorController.php @ impersonate**, make sure you check whether the current user has admin rights. In the code we use an example from [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) to check whether the current user has an admin role. If you use another package, you need to adjust the code with your package.
