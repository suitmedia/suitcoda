<?php

namespace Suitcoda\Http\Requests;

use Suitcoda\Http\Requests\Request;

class GroupRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @property int $id
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' => 'required',
            'slug' => 'alpha_dash',
            'permissions' => ''
        ];

        $this->sanitize();
        
        return $rules;
    }

    /**
     * Get input that has been sanitize
     * @return array
     */
    protected function sanitize()
    {
        $input = $this->all();

        if (!empty($input)) {
            $input[ 'name' ] = filter_var($input[ 'name' ], FILTER_SANITIZE_STRING);
            $input[ 'slug' ] = filter_var($input[ 'slug' ], FILTER_SANITIZE_STRING);
        }

        $this->replace($input);
    }
}
