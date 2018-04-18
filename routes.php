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

    Route::group(['middleware' => ['admin_logged', 'can_see']], function () {

        ////////////////////////////////////////////////////////////////////////
        ////////////////////////////apiS ROUTE///////////////////////////////
        ////////////////////////////////////////////////////////////////////////
        /**
         * list
         */
        Route::get('admin/api', [
            'as' => 'admin_api',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiAdminController@index'
        ]);

        /**
         * edit-add
         */
        Route::get('admin/api/edit', [
            'as' => 'admin_api.edit',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiAdminController@edit'
        ]);

        /**
         * post
         */
        Route::post('admin/api/edit', [
            'as' => 'admin_api.post',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiAdminController@post'
        ]);

        /**
         * delete
         */
        Route::get('admin/api/delete', [
            'as' => 'admin_api.delete',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiAdminController@delete'
        ]);
        ////////////////////////////////////////////////////////////////////////
        ////////////////////////////apiS ROUTE///////////////////////////////
        ////////////////////////////////////////////////////////////////////////




        
        ////////////////////////////////////////////////////////////////////////
        ////////////////////////////CATEGORIES///////////////////////////////
        ////////////////////////////////////////////////////////////////////////
         Route::get('admin/api_category', [
            'as' => 'admin_api_category',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiCategoryAdminController@index'
        ]);

        /**
         * edit-add
         */
        Route::get('admin/api_category/edit', [
            'as' => 'admin_api_category.edit',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiCategoryAdminController@edit'
        ]);

        /**
         * post
         */
        Route::post('admin/api_category/edit', [
            'as' => 'admin_api_category.post',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiCategoryAdminController@post'
        ]);
         /**
         * delete
         */
        Route::get('admin/api_category/delete', [
            'as' => 'admin_api_category.delete',
            'uses' => 'Foostart\Api\Controllers\Admin\ApiCategoryAdminController@delete'
        ]);
        ////////////////////////////////////////////////////////////////////////
        ////////////////////////////CATEGORIES///////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    });
});
