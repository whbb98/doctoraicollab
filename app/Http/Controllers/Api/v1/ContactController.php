<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ContactUpdateRequest;
use App\Http\Resources\v1\ContactCollection;
use App\Http\Resources\v1\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ContactCollection(Contact::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactUpdateRequest $request)
    {
        $contact = Contact::find(1);
        $contact->update($request->all());
        return [
            'success' => 'inserted successfully!'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return new ContactResource([]);
        }
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
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
