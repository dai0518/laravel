<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        return [
            'recruit_title' => 'required|max:255',
            'game_id' => 'required|max:50',
            'discord_url' => 'required|url',
            'comment' => 'required',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',

            
        ];
    }
}
