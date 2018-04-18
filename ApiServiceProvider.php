<?php

namespace Foostart\Api;

use Illuminate\Support\ServiceProvider;
use LaravelAcl\Authentication\Classes\Menu\SentryMenuFactory;

use URL, Route;
use Illuminate\Http\Request;


class ApiServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request) {
        /**
         * Publish
         */
         $this->publishes([
            __DIR__.'/config/api_admin.php' => config_path('api_admin.php'),
        ],'config');

        $this->loadViewsFrom(__DIR__ . '/views', 'api');


        /**
         * Translations
         */
         $this->loadTranslationsFrom(__DIR__.'/lang', 'api');


        /**
         * Load view composer
         */
        $this->apiViewComposer($request);

         $this->publishes([
                __DIR__.'/../database/migrations/' => database_path('migrations')
            ], 'migrations');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        include __DIR__ . '/routes.php';

        /**
         * Load controllers
         */
        $this->app->make('Foostart\Api\Controllers\Admin\ApiAdminController');

         /**
         * Load Views
         */
        $this->loadViewsFrom(__DIR__ . '/views', 'api');
    }

    /**
     *
     */
    public function apiViewComposer(Request $request) {

        view()->composer('api::api*', function ($view) {
            global $request;
            $api_id = $request->get('id');
            $is_action = empty($api_id)?'page_add':'page_edit';

            $view->with('sidebar_items', [

                /**
                 * apis
                 */
                //list
                trans('api::api_admin.page_list') => [
                    'url' => URL::route('admin_api'),
                    "icon" => '<i class="fa fa-list-ul"></i>'
                ],
                //add
                trans('api::api_admin.'.$is_action) => [
                    'url' => URL::route('admin_api.edit'),
                    "icon" => '<i class="fa fa-users"></i>'
                ],

                /**
                 * Categories
                 */
                //list
                trans('api::api_admin.page_category_list') => [
                    'url' => URL::route('admin_api_category'),
                    "icon" => '<i class="fa fa-sitemap"></i>'
                ],
            ]);
            //
        });
    }

}
