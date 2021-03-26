<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUpcomingRequest;
use App\Http\Requests\StoreUpcomingRequest;
use App\Http\Requests\UpdateUpcomingRequest;
use App\Models\Car;
use App\Models\Upcoming;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UpcomingsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('upcoming_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upcomings = Upcoming::with(['car'])->get();

        return view('admin.upcomings.index', compact('upcomings'));
    }

    public function create()
    {
        abort_if(Gate::denies('upcoming_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::all()->pluck('plates', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.upcomings.create', compact('cars'));
    }

    public function store(StoreUpcomingRequest $request)
    {
        $upcoming = Upcoming::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $upcoming->id]);
        }

        return redirect()->route('admin.upcomings.index');
    }

    public function edit(Upcoming $upcoming)
    {
        abort_if(Gate::denies('upcoming_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars = Car::all()->pluck('plates', 'id')->prepend(trans('global.pleaseSelect'), '');

        $upcoming->load('car');

        return view('admin.upcomings.edit', compact('cars', 'upcoming'));
    }

    public function update(UpdateUpcomingRequest $request, Upcoming $upcoming)
    {
        $upcoming->update($request->all());

        return redirect()->route('admin.upcomings.index');
    }

    public function show(Upcoming $upcoming)
    {
        abort_if(Gate::denies('upcoming_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upcoming->load('car');

        return view('admin.upcomings.show', compact('upcoming'));
    }

    public function destroy(Upcoming $upcoming)
    {
        abort_if(Gate::denies('upcoming_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upcoming->delete();

        return back();
    }

    public function massDestroy(MassDestroyUpcomingRequest $request)
    {
        Upcoming::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('upcoming_create') && Gate::denies('upcoming_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Upcoming();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
