<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use App\Models\ServiceStation;
use App\Models\User;
use App\Models\UserRequest;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {
        $services = ServiceStation::where('approved', true)->where('deleted_at', null)->get();
        $cars = Car::where('deleted_at', null)->get();
        $users = User::where('approved', true)->where('deleted_at', null)->get();

        $unactive_users = User::where('approved',false)->where('deleted_at', null)->get();
        $unactive_services = ServiceStation::where('approved', false)->where('deleted_at', null)->get();
        $approve_company = User::whereHas(
            'roles', function($q){
            $q->where('title', 'Between');
        }
        )->get();

        $no_service = ServiceStation::where('deleted_at', null)->pluck('user_id');

        $requests = UserRequest::where('deleted_at', null)->whereNotIn('user_id', $no_service)->get();

        $settings4 = [
            'chart_title'           => 'Rozpoczęte naprawy',
            'chart_type'            => 'pie',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Repair',
            'group_by_field'        => 'started_at',
            'group_by_period'       => 'year',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
        ];

        $chart4 = new LaravelChart($settings4);

        $settings5 = [
            'chart_title'           => 'Naprawy tego roku',
            'chart_type'            => 'pie',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Repair',
            'group_by_field'        => 'finished_at',
            'group_by_period'       => 'year',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'year',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
        ];

        $chart5 = new LaravelChart($settings5);


        abort_if(Gate::denies('Admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('home', compact('requests','approve_company','unactive_users','unactive_services','services','cars','users','chart4', 'chart5'));
    }
}
