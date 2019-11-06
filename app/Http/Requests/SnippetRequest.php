<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SnippetRequest extends FormRequest
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
                    'name' => 'required|string|max:255|unique:snippets',
                    'content' => 'required|string',
                    'location' => 'required|integer',
                    'visible' => 'required|integer',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                        "unique:snippets,name,". $this->snippet->id,
                    ],
                    'content' => 'required|string',
                    'location' => 'required|integer',
                    'visible' => 'required|integer',
                ];
            default:
                break;
        }
    }
}
