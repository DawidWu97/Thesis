<?php

namespace App\Http\Requests;

use App\Models\Repair;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRepairRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('repair_edit');
    }

    public function rules()
    {
        return [
            'calculated_finish' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'finished_at'       => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
