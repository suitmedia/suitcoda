<?php

namespace Suitcoda\Http\Requests;

use Suitcoda\Http\Requests\Request;

class UserRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'name' => 'required',
            'date_of_birth' => '',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];

        $this->merge([ 'is_admin' => $this->input('is_admin', false) ]);
        $this->merge([ 'is_active' => $this->input('is_active', false) ]);
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
            $input[ 'username' ] = filter_var($input[ 'username' ], FILTER_SANITIZE_STRING);
            $input[ 'email' ] = filter_var($input[ 'email' ], FILTER_SANITIZE_EMAIL);
            $input[ 'password' ] = filter_var($input[ 'password' ], FILTER_SANITIZE_STRING);
        }

        $this->replace($input);
    }
}
