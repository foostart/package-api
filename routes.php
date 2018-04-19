<?php

use Illuminate\Session\TokenMismatchException;

/**
 * FRONT
 */
Route::get('api', [
    'as' => 'api',
    'uses' => 'Foostart\Api\Controllers\Front\ApiFrontController@index'
]);


/**
 * ADMINISTRATOR
 */
Route::group(['middleware' => ['web']], function () {

    Route::group(['middleware' => ['admin_logged', 'can_see',],
                  'namespace' => 'Foostart\Api\Controllers\Admin',
        ], function () {

        /*
          |-----------------------------------------------------------------------
          | Manage api
          |-----------------------------------------------------------------------
          | 1. List of apis
          | 2. Edit api
          | 3. Delete api
          | 4. Add new api
          | 5. Manage configurations
          | 6. Manage languages
          |
        */

        /**
         * list
         */
        Route::get('admin/apis/list', [
            'as' => 'apis.list',
            'uses' => 'ApiAdminController@index'
        ]);

        /**
         * edit-add
         */
        Route::get('admin/apis/edit', [
            'as' => 'apis.edit',
            'uses' => 'ApiAdminController@edit'
        ]);

        /**
         * copy
         */
        Route::get('admin/apis/copy', [
            'as' => 'apis.copy',
            'uses' => 'ApiAdminController@copy'
        ]);

        /**
         * post
         */
        Route::post('admin/apis/edit', [
            'as' => 'apis.post',
            'uses' => 'ApiAdminController@post'
        ]);

        /**
         * delete
         */
        Route::get('admin/apis/delete', [
            'as' => 'apis.delete',
            'uses' => 'ApiAdminController@delete'
        ]);

        /**
         * trash
         */
         Route::get('admin/apis/trash', [
            'as' => 'apis.trash',
            'uses' => 'ApiAdminController@trash'
        ]);

        /**
         * configs
        */
        Route::get('admin/apis/config', [
            'as' => 'apis.config',
            'uses' => 'ApiAdminController@config'
        ]);

        Route::post('admin/apis/config', [
            'as' => 'apis.config',
            'uses' => 'ApiAdminController@config'
        ]);

        /**
         * language
        */
        Route::get('admin/apis/lang', [
            'as' => 'apis.lang',
            'uses' => 'ApiAdminController@lang'
        ]);

        Route::post('admin/apis/lang', [
            'as' => 'apis.lang',
            'uses' => 'ApiAdminController@lang'
        ]);

    });
});
