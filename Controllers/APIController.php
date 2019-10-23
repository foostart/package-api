<?php

namespace Foostart\Api\Controlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use URL,
    Route,
    Redirect,
    Response;

use Cartalyst\Sentry\Users\UserNotFoundException;

use Foostart\Api\Lib\Response as LibResponse;

class APIController extends Controller  {

    // object response
    public $obj_res = NULL;
    // response data
    public $response = array(
        'status' => 200, //ID
        'error' => FALSE,  //Boolean status
        'message' => 'Unknow',
        'data' => [

        ],
    );

    public function __construct() {
        $this->obj_res = new LibResponse();
    }

    /**
     * Login
     * @param Request $request
     * @return JSON
     */
    public function login(Request $request) {

        // get params
        $params = $request->all();

        // authentication
        $authentication = \App::make('authenticator');
        $account = [
            'email' => $params['username'],
            'password' => $params['password'],
        ];
        try {

            $user = $authentication->authUser($account);


            $params = [
                'error' => FALSE,
                'message' => trans('api-admin.messages.login-yes'),
                'data' => [
                    'token' => $user->token_api,
                    'csrf' => csrf_token(),
                ]
            ];

        } catch (UserNotFoundException $ex) {

            $params = [
                'error' => TRUE,
                'message' => trans('api-admin.messages.login-no'),
                'data' => [
                ]
            ];
        }

        $this->response = $this->obj_res->resLogin($params);

        // response
        return response()->json($this->response, $this->response['status']);
    }

    /**
     *
     * @param Request $request
     * @return type
     * @date 14/07/2018
     * @loccation S1TT
     */
    public function logout(Request $request) {

        // get params
        $params = $request->all();

        // authentication
        $authentication = \App::make('authenticator');
        $account = [
            'token' => $params['token'],
        ];

        try {

            $user = $authentication->findUserByTokenApiCode($account['token']);

            $authentication->removeTokenByUser($user);

            $params = [
                'error' => FALSE,
                'message' => trans('api-admin.messages.logout-yes'),
                'data' => [
                ]
            ];


        } catch (RuntimeException $ex) {

            $params = [
                'error' => TRUE,
                'message' => trans('api-admin.messages.logout-no-more-token'),
                'data' => [
                ]
            ];

        } catch (UserNotFoundException $ex) {
            $params = [
                'error' => TRUE,
                'message' => trans('api-admin.messages.login-no-not-found'),
                'data' => [
                ]
            ];

        }


        // response
        $this->response = $this->obj_res->resLogin($params);

        return response()->json($this->response, $this->response['status']);
    }

    /**
     *
     * @param Request $request
     * @return type
     * @date 18/07/2018
     * @loccation S1TT
     */
    public function validateCaptcha($params, $captcha) {

        //params
        $res = array(
            'error' => FALSE,
        );

        // Validate captcha
        $captchaValidator = \App::make('captcha_validator');
        $flag = $captchaValidator->validateCaptcha($params, $captcha);
        if (!$flag) {
            $res = [
                'message' => $captchaValidator->getErrorMessage(),
                'error' => TRUE,
            ];

        }

        // response
        $this->response = $this->obj_res->resValidateCaptcha($res);

        return $this->response;
    }

}
