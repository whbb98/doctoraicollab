<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UpdateProfileRequest;
use App\Http\Resources\v1\ProfileDetailsResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\v1\ProfileResource;
use App\Http\Resources\v1\ProfileCollection;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProfileCollection(Profile::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        if ($request->photo) {
            $file = $request->file('photo');
            $profile->updatePhoto($file);
        }
        if ($request->cover) {
            $file = $request->file('cover');
            $profile->updateCover($file);
        }
        $profile->update($request->except('photo', 'cover'));
        return [
            'success' => 'inserted successfully!: '
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($username)
    {
        $user = User::where(['username' => $username])->first();
        if (!$user) {
            return new ProfileDetailsResource([]);
        }
        return new ProfileDetailsResource($user->profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($username)
    {
        $user = User::where(['username' => $username])->first();
        $profile = $user?->profile ?? null;
        if ($profile && $profile->user_id != Auth::user()->id) {
            return [
                'error' => 'access denied!'
            ];
        }
        return [
            'error' => 'method is not supported!'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);
        if ($profile && $profile->user_id != Auth::user()->id) {
            return [
                'error' => 'access denied!'
            ];
        }
        return [
            'error' => 'method is not supported!'
        ];
    }
}
