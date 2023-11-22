<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreateUserRequest;
use App\Models\Contact;
use App\Models\NotificationSettings;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return User::all();
        return new UserCollection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::create($request->all());
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();
        $contact = new Contact();
        $contact->user_id = $user->id;
        $contact->save();
        $notificationSetting = new NotificationSettings();
        $notificationSetting->user_id = $user->id;
        $notificationSetting->save();
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $method = $request->method();
        return $method;
//        return 'update method!';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return 'destroy method!';
    }
}
