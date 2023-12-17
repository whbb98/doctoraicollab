<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\NotificationsRequest;
use App\Http\Resources\v1\NotificationsCollection;
use App\Http\Resources\v1\NotificationsResource;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new NotificationsCollection(
            Auth::user()->receivedNotifications()
                ->orderBy('datetime', 'desc')
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationsRequest $request)
    {
        Notifications::create($request->all());
        return [
            'success' => 'inserted successfully!'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $notification = Notifications::find($id);
        if (!$notification || $notification->receiver != $user->id) {
            return new NotificationsResource([]);
        }
        return new NotificationsResource($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationsRequest $request, $id)
    {
        $user = Auth::user();
        $notification = Notifications::find($id);
        if ($notification && $notification->receiver != $user->id) {
            return [
                'error' => 'permission denied!'
            ];
        }
        if ($notification && $request->method() == 'PATCH') {
            $notification->update($request->all());
            return [
                'success' => 'status updated successfully!'
            ];
        } elseif ($notification && $request->method() == 'PUT') {
            return [
                'error' => $request->method() . ' method is not supported!'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notifications::find($id);
        $user = Auth::user();
        if ($notification && $notification->receiver != $user->id) {
            return [
                'error' => 'permission denied!'
            ];
        } elseif ($notification && $notification->receiver == $user->id) {
            $notification->delete();
            return [
                'success' => 'notification deleted successfully'
            ];
        }
    }
}
