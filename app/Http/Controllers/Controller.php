<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $customMessages = [
        'required' => 'Το πεδίο :attribute είναι απαραίτητο.',
        'integer' => 'Λάθος τιμή για το πεδίο :attribute.',
        'min' => 'Λάθος τιμή για το πεδίο :attribute.'
    ];

    /**
     * validate_params
     */
    public function validate_params(Array $params_array, Array $rules, Array $niceNames=[])
    {
        $validator = Validator::make($params_array, $rules, $this->customMessages);
        if(count($niceNames)>0) $validator->setAttributeNames($niceNames);

        if ($validator->fails()) {
            $error_result = '';
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $error_result .="\n". $message;
            }
            throw new InvalidArgumentException($error_result);
        }

        return $params_array;
    }
}
