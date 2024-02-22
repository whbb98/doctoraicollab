<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UpdateNotificationSettingsRequest;
use App\Http\Resources\v1\NotificationSettingsResource;
use App\Models\NotificationSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notificationSettings = Auth::user()->notificationSettings->makeHidden(['id', 'user_id']);
        return new NotificationSettingsResource($notificationSettings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return [
            'error' => 'method is not supported!'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(NotificationSettings $notificationSettings)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationSettingsRequest $request)
    {
        if ($request->method() == 'PATCH') {
            Auth::user()->notificationSettings->update($request->all());
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
    public function destroy(NotificationSettings $notificationSettings)
    {
        return [
            'error' => 'method is not supported!'
        ];
    }
}
