<?php namespace Foostart\Api\Controllers\Admin;

use Illuminate\Http\Request;
use Foostart\Api\Controllers\Admin\Controller;
use URL;
use Route,
    Redirect;
use Foostart\Api\Models\ApisCategories;
/**
 * Validators
 */
use Foostart\Api\Validators\ApiCategoryAdminValidator;

class ApiCategoryAdminController extends Controller {

    public $data_view = array();

    private $obj_api_category = NULL;
    private $obj_validator = NULL;

    public function __construct() {
        $this->obj_api_category = new ApisCategories();
    }

    /**
     *
     * @return type
     */
    public function index(Request $request) {

         $params =  $request->all();

        $list_api_category = $this->obj_api_category->get_apis_categories($params);

        $this->data_view = array_merge($this->data_view, array(
            'apis_categories' => $list_api_category,
            'request' => $request,
            'params' => $params
        ));
        return view('api::api_category.admin.api_category_list', $this->data_view);
    }

    /**
     *
     * @return type
     */
    public function edit(Request $request) {

        $api = NULL;
        $api_id = (int) $request->get('id');


        if (!empty($api_id) && (is_int($api_id))) {
            $api = $this->obj_api_category->find($api_id);

        }

        $this->data_view = array_merge($this->data_view, array(
            'api' => $api,
            'request' => $request
        ));
        return view('api::api_category.admin.api_category_edit', $this->data_view);
    }

    /**
     *
     * @return type
     */
    public function post(Request $request) {

        $this->obj_validator = new ApiCategoryAdminValidator();

        $input = $request->all();

        $api_id = (int) $request->get('id');

        $api = NULL;

        $data = array();

        if (!$this->obj_validator->validate($input)) {

            $data['errors'] = $this->obj_validator->getErrors();

            if (!empty($api_id) && is_int($api_id)) {

                $api = $this->obj_api_category->find($api_id);
            }

        } else {
            if (!empty($api_id) && is_int($api_id)) {

                $api = $this->obj_api_category->find($api_id);

                if (!empty($api)) {

                    $input['api_category_id'] = $api_id;
                    $api = $this->obj_api_category->update_api_category($input);

                    //Message
                    $this->addFlashMessage('message', trans('api::api_admin.message_update_successfully'));
                    return Redirect::route("admin_api_category.edit", ["id" => $api->api_id]);
                } else {

                    //Message
                    $this->addFlashMessage('message', trans('api::api_admin.message_update_unsuccessfully'));
                }
            } else {

                $api = $this->obj_api_category->add_api_category($input);

                if (!empty($api)) {

                    //Message
                    $this->addFlashMessage('message', trans('api::api_admin.message_add_successfully'));
                    return Redirect::route("admin_api_category.edit", ["id" => $api->api_id]);
                } else {

                    //Message
                    $this->addFlashMessage('message', trans('api::api_admin.message_add_unsuccessfully'));
                }
            }
        }

        $this->data_view = array_merge($this->data_view, array(
            'api' => $api,
            'request' => $request,
        ), $data);

        return view('api::api_category.admin.api_category_edit', $this->data_view);
    }

    /**
     *
     * @return type
     */
    public function delete(Request $request) {

        $api = NULL;
        $api_id = $request->get('id');

        if (!empty($api_id)) {
            $api = $this->obj_api_category->find($api_id);

            if (!empty($api)) {
                  //Message
                $this->addFlashMessage('message', trans('api::api_admin.message_delete_successfully'));

                $api->delete();
            }
        } else {

        }

        $this->data_view = array_merge($this->data_view, array(
            'api' => $api,
        ));

        return Redirect::route("admin_api_category");
    }

}