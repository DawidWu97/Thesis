<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\ServiceStation;
use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UserRequestsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userRequests = UserRequest::with(['user', 'media'])->get();

        return view('admin.userRequests.index', compact('userRequests'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userRequests.create', compact('users'));
    }

    public function store(Request $request)
    {
        $userRequest = UserRequest::create($request->all());

        foreach ($request->input('files', []) as $file) {
            $userRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $userRequest->id]);
        }

        return redirect()->route('admin.user-requests.index');
    }

    public function edit(UserRequest $userRequest)
    {
        abort_if(Gate::denies('user_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userRequest->load('user');

        return view('admin.userRequests.edit', compact('users', 'userRequest'));
    }

    public function update(Request $request, UserRequest $userRequest)
    {
        $userRequest->update($request->all());

        if (count($userRequest->files) > 0) {
            foreach ($userRequest->files as $media) {
                if (!in_array($media->file_name, $request->input('files', []))) {
                    $media->delete();
                }
            }
        }

        $media = $userRequest->files->pluck('file_name')->toArray();

        foreach ($request->input('files', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $userRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('files');
            }
        }

        return redirect()->route('admin.user-requests.index');
    }

    public function show(UserRequest $userRequest)
    {
        abort_if(Gate::denies('user_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userRequest->load('user');

        $services = ServiceStation::wherenull('deleted_at')->where('user_id', $userRequest->user->id)->get();

        return view('admin.userRequests.show', compact('services','userRequest'));
    }

    public function destroy(UserRequest $userRequest)
    {
        abort_if(Gate::denies('user_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userRequest->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        UserRequest::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_request_create') && Gate::denies('user_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new UserRequest();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
