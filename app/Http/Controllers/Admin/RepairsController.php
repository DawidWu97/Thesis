<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRepairRequest;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Models\Car;
use App\Models\Repair;
use App\Models\ServiceStation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RepairsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('repair_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairs = Repair::with(['car', 'station'])->get();

        $cars = Car::get();

        $service_stations = ServiceStation::get();

        return view('admin.repairs.index', compact('repairs', 'cars', 'service_stations'));
    }

    public function create()
    {
        abort_if(Gate::denies('repair_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::all()->pluck('plates', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stations = ServiceStation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.repairs.create', compact('cars', 'stations'));
    }

    public function store(StoreRepairRequest $request)
    {
        $repair = Repair::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $repair->id]);
        }

        return redirect()->route('admin.repairs.index');
    }

    public function edit(Repair $repair)
    {
        abort_if(Gate::denies('repair_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::all()->pluck('plates', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stations = ServiceStation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $repair->load('car', 'station');

        return view('admin.repairs.edit', compact('cars', 'stations', 'repair'));
    }

    public function update(UpdateRepairRequest $request, Repair $repair)
    {
        $repair->update($request->all());

        return redirect()->route('admin.repairs.index');
    }

    public function show(Repair $repair)
    {
        abort_if(Gate::denies('repair_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair->load('car', 'station', 'repairTasks');

        return view('admin.repairs.show', compact('repair'));
    }

    public function destroy(Repair $repair)
    {
        abort_if(Gate::denies('repair_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair->delete();

        return back();
    }

    public function massDestroy(MassDestroyRepairRequest $request)
    {
        Repair::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('repair_create') && Gate::denies('repair_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Repair();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
