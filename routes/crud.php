<?php

use App\Http\Controllers\Admin\PhotoController;

          Route::group(['as'=>'admin.', 'prefix' => 'admin', 'middleware' => 'auth:admin' ], function(){

            //crud-routes

            Route::resource('photos', PhotoController::class);
               
          });
