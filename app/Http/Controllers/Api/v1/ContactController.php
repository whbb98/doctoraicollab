<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ContactUpdateRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auth::user()->contact;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactUpdateRequest $request)
    {
        $contact = Auth::user()->contact;
        $contact->update($request->all());
        return [
            'success' => 'updated successfully!'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
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
    public function destroy(Contact $contact)
    {
        return [
            'error' => 'method is not supported!'
        ];
    }
}
