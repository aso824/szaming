<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show profile settings.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }

    /**
     * Update User profile.
     *
     * @param \App\Http\Requests\User\UpdateProfile $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfile $request): RedirectResponse
    {
        $data = $request->validated();

        $userId = request()->route('profile');
        $user = User::findOrFail($userId);
        $user->fill($data);
        $user->save();

        return redirect()->route('profile.index')
                         ->with('success', 'Your profile has been updated.');
    }
}
