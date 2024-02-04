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
    public function index(Request $req)
    {
        $query = Profile::query();
        if ($req->filled('user')) {
            $query->whereHas('user', function ($subquery) use ($req) {
                $searchTerm = '%' . $req->input('user') . '%';
                $subquery->where('email', 'like', $searchTerm)
                    ->orWhere('username', 'like', $searchTerm)
                    ->orWhere('first_name', 'like', $searchTerm)
                    ->orWhere('last_name', 'like', $searchTerm);
            });
        }
        if ($req->filled('city')) {
            $query->where('city', $req->input('city'));
        }
        if ($req->filled('hospital')) {
            $query->where('hospital', 'like', '%' . $req->input('hospital') . '%');
        }
        if ($req->filled('department')) {
            $query->where('department', 'like', '%' . $req->input('department') . '%');
        }
        if ($req->filled('occupation')) {
            $query->where('occupation', 'like', '%' . $req->input('occupation') . '%');
        }
        $profiles = $query->paginate();
        return new ProfileCollection($profiles);
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
