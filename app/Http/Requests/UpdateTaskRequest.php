<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('task_edit');
    }

    public function rules()
    {
        return [
            'name'      => [
                'string',
                'max:255',
                'required',
            ],
            'duration'  => [
                'numeric',
                'required',
                'max:100000',
            ],
            'repair_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
