<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMyProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MyProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = $request->user()->profile;

        return view('my-profile.edit', [
            'profile' => $profile,
        ]);
    }

    public function update(UpdateMyProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->profile()->updateOrCreate(
            [],
            $request->validated()
        );

        return redirect()
            ->route('my-profile.edit')
            ->with('success', __('messages.my_profile_saved'));
    }
}