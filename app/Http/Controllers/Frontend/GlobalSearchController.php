<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ServiceStation;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    private $models = [
        'ServiceStation' => 'Warsztat Samochodowy',
    ];

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search === null || !isset($search['term'])) {
            abort(400);
        }

         $term           = $search['term'];
         $searchableData = [];

        foreach ($this->models as $model => $translation) {
            $modelClass = 'App\Models\\' . $model;

            $results = ServiceStation::
                  where('approved',   true)
                ->where('deleted_at', null)
                ->where(function ($query) use ($term){
                    $query->where('name', 'LIKE', '%' . $term . '%')
                        ->orWhere('phone', 'LIKE', '%' . $term . '%')
                        ->orWhere('city', 'LIKE', '%' . $term . '%')
                        ->orWhere('street', 'LIKE', '%' . $term . '%');
                })
                ->take(20)
                ->get();

            $fields = [
                'name',
                'phone',
                'city',
                'street',
                'postcode',
            ];

            if($request['fastest']=="true") {
                $now = Carbon::now();
                $begin = $now;
                $end_year = date_add($begin, date_interval_create_from_date_string('1 year'));
                $day = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod(Carbon::now(), $day, $end_year);
                $fastest = $end_year;
                foreach ($results as $result) {
                    $free = null;
                    foreach ($period as $date) {
                        if($date->format('N')<6)
                        {
                            $interval = DateInterval::createFromDateString('1 hour');
                            $start = $result->opening;
                            $end = $result->closing;
                            $current = $date->format('d-m-Y');
                            $start_date = date_create($current . '' . $start);
                            $end_date = date_create($current . '' . $end);
                            $open = new DatePeriod($start_date, $interval, $end_date);
                            foreach ($open as $time) {
                                $repairs =
                                    $result
                                        ->stationRepairs()->where('approved', true)->wherenull('finished_at')
                                        ->wherenotnull('calculated_finish')
                                        ->where('suspend', false)
                                        ->where('started_at', '<=', $time)
                                        ->where('calculated_finish', '>=', $time)
                                        ->get();
                                if(count($repairs)<$result->workplaces)
                                {
                                    $free = $date;
                                    if ($free < $fastest) {
                                        $fastest = $free;
                                    }
                                    break;
                                }
                            }
                        }
                        if ($free != null)
                            break;
                    }
                }
            }

            foreach ($results as $result) {
                $category = $result->categories->where('id', $request['category']);
                $date = $request['date'];
                $weekend = (date_create($date)->format('N') >= 6);

                if(date_create($date) < Carbon::now() OR $weekend==true)
                    $min = $result->workplaces;

                if($request['fastest']=="true")
                {
                    $date = $fastest->format('d-m-Y');
                }

                if($weekend==false AND (date_create($date)>Carbon::now()->subDay()))
                {
                    $interval = DateInterval::createFromDateString('1 hour');
                    $start = $result->opening;
                    $end = $result->closing;
                    $start_date = date_create($date.''.$start);
                    $end_date = date_create($date.''.$end);
                    $period = new DatePeriod($start_date, $interval, $end_date);
                    $space = array();
                    foreach ($period as $time) {
                        $repairs =
                        $result
                            ->stationRepairs()->where('approved', true)->wherenull('finished_at')
                            ->wherenotnull('calculated_finish')
                            ->where('suspend', false)
                            ->where('started_at','<=',$time)
                            ->where('calculated_finish','>=',$time)
                            ->get();
                        array_push($space,count($repairs));
                    }
                    $unique = array_unique($space, $flags = SORT_NUMERIC);
                    $min = min($unique);
                }

                if(count($category)>0 AND ($min<$result->workplaces)) {
                    $parsedData = $result->only($fields);
                    $parsedData['model'] = trans($translation);
                    $parsedData['fields'] = $fields;
                    $formattedFields = [];


                    $formattedFields['name'] = 'Nazwa';
                    $formattedFields['phone'] = 'Telefon';
                    $formattedFields['city'] = 'Miasto';
                    $formattedFields['street'] = 'Ulica';
                    $formattedFields['postcode'] = 'Kod pocztowy';


                    $parsedData['fields_formated'] = $formattedFields;

                    $parsedData['url'] = url('/app/' . Str::plural(Str::snake($model, '-')) . '/' . $result->id);

                    if ($result->photo)
                        $parsedData['photo'] = $result->photo->getUrl();
                    else
                        $parsedData['photo'] = "/storage/service_station_default.jpg";

                    $searchableData[] = $parsedData;
                }
            }
        }

        return response()->json(['results' => $searchableData]);
    }
}
