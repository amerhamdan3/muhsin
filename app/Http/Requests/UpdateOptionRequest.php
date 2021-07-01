<?php

namespace App\Http\Requests;

use App\Models\Option;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('option_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:options,title,' . request()->route('option')->id,
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
