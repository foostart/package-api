<?php namespace Foostart\Api\Controlers;

use Illuminate\Http\Request;

use URL,
    Route,
    Redirect,
    Response,
    App;
use Foostart\Comment\Models\Comment;
use Cartalyst\Sentry\Users\UserNotFoundException;

class APICommentController extends APIController
{

    public $obj_comment = NULL;

    public function __construct() {

        // object comment
        $this->obj_comment = new Comment();
        parent::__construct();
    }

    public function getComments($context, $id, Request $request)
    {
        $comments = $this->obj_comment->selectItems();

        list($commentsArray, $usersArray) = $this->obj_comment->mapCommentArray($comments);


        $this->response = array_merge($this->response, [
            'data' => [
                'commentsArray' => $commentsArray,
                'usersArray' => $usersArray,
            ]
        ]);

        return response()->json($this->response, $this->response['status']);

    }

    /**
     * Post comment
     * @param Request $request
     * @return type Description
     * @date 17/07/2018
     * @location S1TT
     */
    public function postComment($context_name, $context_id, Request $request) {

        // Get params
        $params = $request->all();
        $params['captcha-image'] = isset($params['captcha-image'])?$params['captcha-image']:$params['captcha_image'];
        $params['context_name'] = $context_name;
        $params['context_id'] = $context_id;
        //Show captcha
        $res = $this->validateCaptcha($params, $params['captcha-image']);

        if (!$res['error']) {
            // authentication
            if (!empty($params['token_api'])) {

                $authentication = \App::make('authenticator');

                try {

                    $user = $authentication->findUserByTokenApiCode($params['token_api']);

                    $params = array_merge($params, [
                        'creator' => $user->id,
                    ]);

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
            }
        }


        // Save to database
        if ($this->response['status']) {

            if ($params['id']) {
                //update
                $this->obj_comment->updateItem($params);
            } else {
                //insert
                $this->obj_comment->insertItem($params);
            }

        }


        // Response to client
        return response()->json($this->response, $this->response['status']);
    }


    public function voteComment(Request $request) {

        // Get params
        $params = $request->all();

        // Get voted user
        $authentication = \App::make('authenticator');
        $user = NULL;
        if (!empty($params['token_api'])) {
            try {
                $user = $authentication->findUserByTokenApiCode($params['token_api']);
            } catch (\RuntimeException $ex) {
                $this->response['message'] = 'test';
            } catch (UserNotFoundException $ex) {
                $this->response['message'] = 'test';

            }
        } else {
            $user = $authentication->getLoggedUser();
        }
        $params['user_id'] = $user->id;

        // Save like to comment
        $this->obj_comment->vote($params);

        $this->response['access'] = TRUE;
        return response()->json($this->response, $this->response['status']);
    }

    public function deleteComment($context_name, $context_id, Request $request) {

        // Get params
        $params = $request->all();
        $params['captcha-image'] = isset($params['captcha-image'])?$params['captcha-image']:$params['captcha_image'];
        $params['context_name'] = $context_name;
        $params['context_id'] = $context_id;
        //Show captcha
        $res = $this->validateCaptcha($params, $params['captcha-image']);

        if (!$res['error']) {
            // authentication
            if (!empty($params['token_api'])) {

                $authentication = \App::make('authenticator');

                try {

                    $user = $authentication->findUserByTokenApiCode($params['token_api']);

                    $params = array_merge($params, [
                        'creator' => $user->id,
                    ]);

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
            }
        }

        // Save to database
        if ($this->response['status']) {

            if ($params['id']) {
                //update
                $this->obj_comment->deleteItem($params, 'delete-forever');
            }

        }

        // Response to client
        return response()->json($this->response, $this->response['status']);
    }

}