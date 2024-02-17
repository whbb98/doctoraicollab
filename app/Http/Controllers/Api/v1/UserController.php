<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreateUserRequest;
use App\Http\Requests\v1\UpdateUserRequest;
use App\Http\Resources\v1\UserDetailsResource;
use App\Models\Contact;
use App\Models\NotificationSettings;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\UserCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserCollection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create($request->all());
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();
            $contact = new Contact();
            $contact->user_id = $user->id;
            $contact->save();
            $notificationSettings = new NotificationSettings();
            $notificationSettings->user_id = $user->id;
            $notificationSettings->save();
            DB::commit();
            return new UserResource($user);
        } catch (e) {
            DB::rollBack();
            return [
                'error'=>'Error while creating a new user!'
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($username)
    {
        $user = User::where(['username' => $username])->first();
        if ($user && $user->id != Auth::user()->id) {
            return [
                'error' => 'permission denied!'
            ];
        }
        if (!$user) {
            return new UserDetailsResource([]);
        }
        return new UserDetailsResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->method() == 'PATCH') {
            $user->update($request->all());
            return [
                'success' => 'updated successfully!'
            ];
        } else {
            return [
                'error' => 'method is not supported!'
            ];
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return [
            'error' => 'method is not supported!'
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'error' => 'Invalid Credentials!'
            ];
        } else {
            $token = $user->createToken('auth_token')->plainTextToken;
            return [
                'auth_user' => new UserResource($user),
                'auth_token' => $token
            ];
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'success' => 'You have successfully logged out! ' . Auth::user()->first_name
        ];
    }

}
