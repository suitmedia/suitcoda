<?php

namespace Suitcoda\Http\Requests;

use Suitcoda\Http\Requests\Request;

class ProjectRequest extends Request
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
            'name' => 'required|unique:projects,name',
            'main_url' => 'required|url',
        ];

        $this->sanitize();

        return $rules;
    }

    /**
     * Get input that has been sanitize
     *
     * @return void
     */
    protected function sanitize()
    {
        $input = $this->all();

        if (!empty($input['name']) &&
            !empty($input['main_url'])) {
            $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
            $input['main_url'] = filter_var($input['main_url'], FILTER_SANITIZE_URL);
        }

        $this->replace($input);
    }
}
