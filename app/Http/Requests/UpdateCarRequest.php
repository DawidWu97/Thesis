<?php

namespace App\Http\Requests;

use App\Models\Car;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('car_edit');
    }

    public function rules()
    {
        return [
            'brand'          => [
                'string',
                'max:30',
                'required',
            ],
            'model'          => [
                'string',
                'max:50',
                'required',
            ],
            'engine'         => [
                'string',
                'max:150',
                'required',
            ],
            'vin'            => [
                'string',
                'max:25',
                'required',
            ],
            'plates'         => [
                'string',
                'max:10',
                'required',
                'unique:cars,plates,' . request()->route('car')->id,
            ],
            'bought_mileage' => [
                'required',
                'integer',
                'min:1',
                'max:21474836',
            ],
            'bought_at'      => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'before:yesterday',
            ],
        ];
    }
}
