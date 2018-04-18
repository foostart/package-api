<?php

namespace Foostart\Api\Models;

use Illuminate\Database\Eloquent\Model;

class ApisCategories extends Model {

    protected $table = 'apis_categories';
    public $timestamps = false;
    protected $fillable = [
        'api_category_name'
    ];
    protected $primaryKey = 'api_category_id';

    public function get_apis_categories($params = array()) {
        $eloquent = self::orderBy('api_category_id');

        if (!empty($params['api_category_name'])) {
            $eloquent->where('api_category_name', 'like', '%'. $params['api_category_name'].'%');
        }
        $apis_category = $eloquent->paginate(10);
        return $apis_category;
    }

    /**
     *
     * @param type $input
     * @param type $api_id
     * @return type
     */
    public function update_api_category($input, $api_id = NULL) {

        if (empty($api_id)) {
            $api_id = $input['api_category_id'];
        }

        $api = self::find($api_id);

        if (!empty($api)) {

            $api->api_category_name = $input['api_category_name'];

            $api->save();

            return $api;
        } else {
            return NULL;
        }
    }

    /**
     *
     * @param type $input
     * @return type
     */
    public function add_api_category($input) {

        $api = self::create([
                    'api_category_name' => $input['api_category_name'],
        ]);
        return $api;
    }

    /**
     * Get list of apis categories
     * @param type $category_id
     * @return type
     */
     public function pluckSelect($category_id = NULL) {
        if ($category_id) {
            $categories = self::where('api_category_id', '!=', $category_id)
                    ->orderBy('api_category_name', 'ASC')
                ->pluck('api_category_name', 'api_category_id');
        } else {
            $categories = self::orderBy('api_category_name', 'ASC')
                ->pluck('api_category_name', 'api_category_id');
        }
        return $categories;
    }

}
