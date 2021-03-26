<?php

namespace App\Http\Requests;

use App\Models\ServiceStation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreServiceStationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_station_create');
    }

    public function rules()
    {
        return [
            'user_id'    => [
                'required',
                'integer',
            ],
            'name'       => [
                'string',
                'min:3',
                'max:255',
                'required',
            ],
            'phone'      => [
                'string',
                'min:7',
                'max:20',
                'required',
            ],
            'opening'    => [
                'required',
                'date_format:' . config('panel.time_format'),
                'before:closing',
            ],
            'closing'    => [
                'required',
                'date_format:' . config('panel.time_format'),
                'after:opening',
            ],
            'workplaces' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
            'city'       => [
                'string',
                'min:2',
                'max:255',
                'required',
            ],
            'street'     => [
                'string',
                'max:255',
                'required',
            ],
            'postcode'   => [
                'string',
                'min:4',
                'max:8',
                'required',
            ],
        ];
    }
}
