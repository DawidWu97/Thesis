<?php

namespace App\Http\Requests;

use App\Models\Part;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePartRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('part_create');
    }

    public function rules()
    {
        return [
            'name'  => [
                'string',
                'max:255',
                'required',
            ],
            'price' => [
                'required',
            ],
        ];
    }
}
