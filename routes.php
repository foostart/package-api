<?php

use Illuminate\Session\TokenMismatchException;

/**
 * LOGIN
 */
Route::group(['middleware' => ['web'], 'namespace' => 'Foostart\Api\Controlers',], function () {
    Route::get('api/login', [
        'as' => 'api.login',
        'uses' => 'APIController@login'
    ]);

    /**
     * LOGOUT
     */
    Route::get('api/logout', [
        'as' => 'api.logout',
        'uses' => 'APIController@logout'
    ]);
});

/*
|-----------------------------------------------------------------------
| COMMENT API
|-----------------------------------------------------------------------
| 1. Get list of comments
| 2. Post a comment
| 3. Vote a comment
|
*/
Route::group(['middleware' => ['web'], 'namespace' => 'Foostart\Api\Controlers',], function () {
    /**
     * Get list comments by context id
     */
    Route::get('api/comment/{context}/{id}', [
        'as' => 'api.get_comments',
        'uses' => 'APICommentController@getComments'
    ]);

    /**
     * Post a comment by context id
     */
    Route::post('api/post-comment/{context}/{id}', [
        'as' => 'api.post_comment',
        'uses' => 'APICommentController@postComment'
    ]);

    /**
     * Delete a comment by context id
     */
    Route::post('api/delete-comment/{context}/{id}', [
        'as' => 'api.delete_comment',
        'uses' => 'APICommentController@deleteComment'
    ]);

    /**
     * Vote a comment
     */
    Route::post('api/vote-comment/{context}/{id}', [
        'as' => 'api.vote-comment',
        'uses' => 'APICommentController@voteComment'
    ])->middleware('api_admin_logged');

});


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
