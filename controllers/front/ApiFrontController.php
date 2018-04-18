<?php

namespace Foostart\Api\Controlers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use URL,
    Route,
    Redirect;
use Foostart\Api\Models\Apis;

class ApiFrontController extends Controller
{
    public $data = array();
    public function __construct() {

    }

    public function index(Request $request)
    {

        $obj_api = new Apis();
        $apis = $obj_api->get_apis();
        $this->data = array(
            'request' => $request,
            'apis' => $apis
        );
        return view('api::api.index', $this->data);
    }

}