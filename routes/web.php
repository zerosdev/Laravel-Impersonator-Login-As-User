<?php

Route::get('/admin/impersonate/{user_id}', 'ImpersonatorController@impersonate');
Route::get('/impersonator/rollback', 'ImpersonatorController@rollback');

?>