<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'title' => 'required|string|max:255',
                    'key' => 'required|string|max:255|unique:settings',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => 'required|string|max:255',
                    'key' => 'nullable|string|max:255',
                ];
            default:
                break;
        }
    }
}
