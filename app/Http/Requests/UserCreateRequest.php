<?php

namespace Suitcoda\Http\Requests;

use Suitcoda\Http\Requests\Request;

class UserCreateRequest extends Request
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
            'username' => 'required|alpha_dash|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'name' => 'required',
            'is_admin' => 'required|boolean',
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

        if (!empty($input[ 'name' ]) &&
            !empty($input[ 'username' ]) &&
            !empty($input[ 'email' ]) &&
            !empty($input[ 'password' ])) {
            $input[ 'name' ] = filter_var($input[ 'name' ], FILTER_SANITIZE_STRING);
            $input[ 'username' ] = filter_var($input[ 'username' ], FILTER_SANITIZE_STRING);
            $input[ 'email' ] = filter_var($input[ 'email' ], FILTER_SANITIZE_EMAIL);
            $input[ 'password' ] = filter_var($input[ 'password' ], FILTER_SANITIZE_STRING);
        }

        $this->replace($input);
    }
}
