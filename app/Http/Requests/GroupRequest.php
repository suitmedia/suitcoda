<?php

namespace Suitcoda\Http\Requests;

use Suitcoda\Http\Requests\Request;
use Suitcoda\Model\Group;

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
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        return [
            'name' => 'required',
            'slug' => 'alpha_dash|unique:roles,slug,' . $this->id,
        ];
    }

    protected function sanitize()
    {
        $input = $this->all();

        if (!empty($input)) {
            $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
            $input['slug'] = filter_var($input['slug'], FILTER_SANITIZE_STRING);
        }

        $this->replace($input);
    }
}
