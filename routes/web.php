<?php

Route::get('/admin/impersonate/{user_id}', 'ImpersonateController@impersonate');
Route::get('/impersonate/rollback', 'ImpersonateController@rollback');

?>