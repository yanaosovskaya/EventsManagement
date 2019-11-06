<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
        $code = request('code');

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name' => 'required|string|max:255',
                    'code' => 'required|string|max:255|unique:menus',
                    'type' => 'integer',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|string|max:255',
                    'code' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('menus')->ignore($code, 'code')
                    ],
                    'type' => 'integer',
                ];
            default:
                break;
        }
    }
}
