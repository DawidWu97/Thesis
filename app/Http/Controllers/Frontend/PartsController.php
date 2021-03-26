<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPartRequest;
use App\Http\Requests\StorePartRequest;
use App\Http\Requests\UpdatePartRequest;
use App\Models\Part;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('part_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parts = Part::with(['task'])->get();

        return view('frontend.parts.index', compact('parts'));
    }

    public function create()
    {
        abort_if(Gate::denies('part_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tasks = Task::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.parts.create', compact('tasks'));
    }

    public function store(StorePartRequest $request)
    {
        $part = Part::create($request->all());

        return redirect()->route('frontend.parts.index');
    }

    public function edit(Part $part)
    {
        abort_if(Gate::denies('part_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tasks = Task::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $part->load('task');

        return view('frontend.parts.edit', compact('tasks', 'part'));
    }

    public function update(UpdatePartRequest $request, Part $part)
    {
        $part->update($request->all());

        return redirect()->route('frontend.parts.index');
    }

    public function show(Part $part)
    {
        abort_if(Gate::denies('part_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $part->load('task');

        return view('frontend.parts.show', compact('part'));
    }

    public function destroy(Part $part)
    {
        abort_if(Gate::denies('part_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $part->delete();

        return back();
    }

    public function massDestroy(MassDestroyPartRequest $request)
    {
        Part::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
