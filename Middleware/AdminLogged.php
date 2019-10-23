<?php  namespace Foostart\Api\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Foostart\Api\Lib\Response as LibResponse;
/*
 * Check that the current user is logged and active and redirect to client login or
 * to custom url if given
 */
class AdminLogged {

    public function handle($request, Closure $next, $custom_url = null)
    {
        // params
        $response = array(
            'error' => FALSE,
            'url_login' => url('/login'),
        );
        $obj_res = new LibResponse();
        $response = $obj_res->resLogin($response);

        if(!App::make('authenticator')->check()) {
            $response['error'] = TRUE;
            $response['message'] = 'Required login';
            return response()->json($response, $response['status']);
        }


        return $next($request);
    }
}