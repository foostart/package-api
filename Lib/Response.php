<?php namespace Foostart\Api\Lib;

use Illuminate\Http\Response as CoreResponse;

class Response extends CoreResponse {

    /**
     * Response authentication
     * @param type $params
     * @return type
     */
    public function resLogin($params = array()) {

        if (!$params['error']) {
            $params['status'] = self::HTTP_OK;
        } else {
            $params['status'] = self::HTTP_UNAUTHORIZED;
        }

        return $params;
    }

    public function resValidateCaptcha($params) {
        if (!$params['error']) {
            $params['status'] = self::HTTP_OK;
        } else {
            $params['status'] = self::HTTP_UNAUTHORIZED;
        }

        return $params;
    }
}