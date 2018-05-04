<?php namespace Foostart\Api\Validators;

use Foostart\Category\Library\Validators\FooValidator;
use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;
use Foostart\Api\Models\Api;

use Illuminate\Support\MessageBag as MessageBag;

class ApiValidator extends FooValidator
{

    protected $obj_api;

    public function __construct()
    {
        // add rules
        self::$rules = [
            'api_name' => ["required"],
            'api_overview' => ["required"],
            'api_description' => ["required"],
            'api_status' => ["required"],
        ];

        // set configs
        self::$configs = $this->loadConfigs();

        // model
        $this->obj_api = new Api();

        // language
        $this->lang_front = 'api-front';
        $this->lang_admin = 'api-admin';

        // event listening
        Event::listen('validating', function($input)
        {
            self::$messages = [
                'api_name.required'          => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.name')]),
                'api_overview.required'      => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.overview')]),
                'api_description.required'   => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.description')]),
                'api_statuses.required'          => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.update_at')]),
            ];
        });


    }

    /**
     *
     * @param ARRAY $input is form data
     * @return type
     */
    public function validate($input) {

        $flag = parent::validate($input);
        $this->errors = $this->errors ? $this->errors : new MessageBag();

        //Check length
        $_ln = self::$configs['length'];

        $params = [
            'name' => [
                'key' => 'api_name',
                'label' => trans($this->lang_admin.'.fields.name'),
                'min' => $_ln['api_name']['min'],
                'max' => $_ln['api_name']['max'],
            ],
            'overview' => [
                'key' => 'api_overview',
                'label' => trans($this->lang_admin.'.fields.overview'),
                'min' => $_ln['api_overview']['min'],
                'max' => $_ln['api_overview']['max'],
            ],
            'description' => [
                'key' => 'api_description',
                'label' => trans($this->lang_admin.'.fields.description'),
                'min' => $_ln['api_description']['min'],
                'max' => $_ln['api_description']['max'],
            ],
        ];

        $flag = $this->isValidLength($input['api_name'], $params['name']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['api_overview'], $params['overview']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['api_description'], $params['description']) ? $flag : FALSE;

        return $flag;
    }


    /**
     * Load configuration
     * @return ARRAY $configs list of configurations
     */
    public function loadConfigs(){

        $configs = config('package-api');
        return $configs;
    }

}