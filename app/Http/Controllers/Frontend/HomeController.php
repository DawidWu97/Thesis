<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Car;
use App\Models\Repair;
use App\Models\ServiceStation;
use App\Models\Upcoming;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;

class HomeController
{
    public function index()
    {
        $active_stations = Auth::user()->userServiceStations()->where("approved",true)->where('deleted_at', null)->get();
        $repairs = $active_stations->pluck('id');
        $active_repairs = Repair::whereIn('station_id',$repairs)->where('started_at','<',Carbon::now())->where('finished_at', null)->where('approved', true)->orderBy('started_at','asc')->get();
        $planned_repairs = Repair::whereIn('station_id',$repairs)->where('started_at','>',Carbon::now())->where('finished_at', null)->where('approved', true)->orderBy('started_at','asc')->get();
        $approvable_repairs = Repair::whereIn('station_id',$repairs)->where('approved', false)->where('canceled', false)->orderBy('started_at','asc')->get();
        $repairs_count = Repair::whereIn('station_id',$repairs)->wherenotnull('finished_at')->get();
        $vin = array();
        foreach ($repairs_count as $query)
        {
            $number= DB::table('cars')->where('id', $query->car_id)->value('vin');
            array_push($vin,$number);
        }
        $vin_unique = array_unique($vin, $flags = SORT_NUMERIC);
        $count = count($vin_unique);

        $user_cars = Auth::user()->userCars()->get();
        $cars = $user_cars->pluck('id');
        $user_repairs_active = Repair::whereIn('car_id', $cars)->where('finished_at', null)->where('approved', true)->orderBy('started_at','asc')->get();
        $user_repairs_waiting = Repair::whereIn('car_id', $cars)->where('canceled', false)->where('approved', false)->orderBy('started_at','asc')->get();
        $upcomings = Upcoming::whereIn('car_id', $cars)->where('repair_at','>',\Carbon\Carbon::now())->orderBy('repair_at','asc')->get();

        return view('frontend.home', compact('planned_repairs','upcomings',"count",'repairs_count','user_repairs_active','user_repairs_waiting','active_stations','active_repairs','approvable_repairs'));
    }
}
