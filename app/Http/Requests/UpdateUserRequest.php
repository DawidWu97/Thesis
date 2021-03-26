<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name'     => [
                'string',
                'min:3',
                'max:255',
                'required',
            ],
            'username' => [
                'string',
                'min:5',
                'max:255',
                'required',
                'unique:users,username,' . request()->route('user')->id,
            ],
            'email'    => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'required',
                'array',
            ],
        ];
    }
}
