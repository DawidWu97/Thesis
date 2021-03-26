<?php

namespace App\Http\Requests;

use App\Models\Upcoming;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUpcomingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('upcoming_edit');
    }

    public function rules()
    {
        return [
            'car_id'      => [
                'required',
                'integer',
            ],
            'description' => [
                'required',
            ],
            'mileage'     => [
                'nullable',
                'integer',
                'min:1',
                'max:21474836',
            ],
            'repair_at'   => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'after:tomorrow',
            ],
        ];
    }
}
