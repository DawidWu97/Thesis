<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\UserAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function index()
    {
        return view('frontend.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return redirect()->route('frontend.profile.index')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->userServiceStations()->update(['deleted_at' => Carbon::now(), 'approved' => false]);
        $user->userCars()->update(['deleted_at' => Carbon::now()]);

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }

    public function password(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('frontend.profile.index')->with('message', __('global.change_password_success'));
    }
    public function approve(Request $request)
    {
        $repair = Auth::user();
        $repair->roles()->sync(4,auth()->user()->id);
        $repair->save();

        $useralert = new UserAlert();
        $useralert->alert_text = "Nowy przedsiębiorca";
        $useralert->alert_link = "/admin/users/".auth()->user()->id;
        $useralert->save();
        $useralert->users()->sync(1);
    }
}
