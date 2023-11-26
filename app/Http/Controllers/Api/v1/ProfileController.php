<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\v1\ProfileResource;
use App\Http\Resources\v1\ProfileCollection;

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
        $user = User::find(2);//tomporary usage (will be replaced with sanctum)
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
    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        return [
            'error' => 'method is not supported!'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        return [
            'error' => 'method is not supported!'
        ];
    }
}
