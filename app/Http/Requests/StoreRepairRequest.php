<?php

namespace App\Http\Requests;

use App\Models\Repair;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRepairRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('repair_create');
    }

    public function rules()
    {
        return [
            'car_id'            => [
                'required',
                'integer',
            ],
            'station_id'        => [
                'required',
                'integer',
            ],
            'mileage'           => [
                'required',
                'integer',
                'min:1',
                'max:21474836',
            ],
            'started_at'        => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'after:tomorrow',
            ],
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
