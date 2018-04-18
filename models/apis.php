<?php

namespace Foostart\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Apis extends Model {

    protected $table = 'apis';
    public $timestamps = false;
    protected $fillable = [
        'api_name',
        'category_id'
    ];
    protected $primaryKey = 'api_id';

    /**
     *
     * @param type $params
     * @return type
     */
    public function get_apis($params = array()) {
        $eloquent = self::orderBy('api_id');

        //api_name
        if (!empty($params['api_name'])) {
            $eloquent->where('api_name', 'like', '%'. $params['api_name'].'%');
        }

        $apis = $eloquent->paginate(10);//TODO: change number of item per page to configs

        return $apis;
    }



    /**
     *
     * @param type $input
     * @param type $api_id
     * @return type
     */
    public function update_api($input, $api_id = NULL) {

        if (empty($api_id)) {
            $api_id = $input['api_id'];
        }

        $api = self::find($api_id);

        if (!empty($api)) {

            $api->api_name = $input['api_name'];
            $api->category_id = $input['category_id'];

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
    public function add_api($input) {

        $api = self::create([
                    'api_name' => $input['api_name'],
                    'category_id' => $input['category_id'],
        ]);
        return $api;
    }
}
