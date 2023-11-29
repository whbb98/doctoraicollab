<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\NotificationsRequest;
use App\Http\Resources\v1\NotificationsCollection;
use App\Http\Resources\v1\NotificationsResource;
use App\Models\Notifications;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new NotificationsCollection(Notifications::paginate());
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
        $notification = Notifications::find($id);
        if (!$notification) {
            return new NotificationsResource([]);
        }
        return new NotificationsResource($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationsRequest $request, Notifications $notification)
    {
        if ($request->method() == 'PATCH') {
            $notification->update($request->all());
            return [
                'success' => 'status updated successfully!'
            ];
        } else {
            return [
                'error' => $request->method() . ' method is not supported!'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notifications $notification)
    {
        return [
            'method soon will be implemented hhhh!'
        ];
    }
}
