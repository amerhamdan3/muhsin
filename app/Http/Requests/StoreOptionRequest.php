<?php

namespace App\Http\Requests;

use App\Models\Option;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('option_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:options',
            ],
            'pages.*' => [
                'integer',
            ],
            'pages' => [
                'array',
            ],
            'blogs.*' => [
                'integer',
            ],
            'blogs' => [
                'array',
            ],
            'belongto' => [
                'string',
                'nullable',
            ],
        ];
    }
}
