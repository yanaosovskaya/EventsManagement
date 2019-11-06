<?php

namespace App\Http\Requests\Menu;

use App\Models\MenuItem;
use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
        $type = request('type');

        switch ($type) {
            case MenuItem::TYPE_LINK:
                return [
                    'content' => 'required|string|max:255',
                    'name' => 'required|string|max:255',
                    'type' => 'required|integer',
                    'menu_id' => 'required|exists:menus,id',
                    'parent_id' => 'nullable|exists:menu_items,id',
                    'visible' => 'nullable|integer',
                ];
                break;
            case MenuItem::TYPE_TEXT:
                return [
                    'name' => 'required|string|max:255',
                    'type' => 'required|integer',
                    'menu_id' => 'required|exists:menus,id',
                    'parent_id' => 'nullable|exists:menu_items,id',
                    'visible' => 'nullable|integer',
                ];
                break;
            default:
                return [
                    'content' => 'required|integer|exists:pages,id',
                    'name' => 'required|string|max:255',
                    'type' => 'required|integer',
                    'menu_id' => 'required|exists:menus,id',
                    'parent_id' => 'nullable|exists:menu_items,id',
                    'visible' => 'nullable|integer',
                ];
        }
    }
}
