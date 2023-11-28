<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UpdateCareerRequest;
use App\Http\Resources\v1\CareerCollection;
use App\Http\Resources\v1\CareerResource;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CareerCollection(Career::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateCareerRequest $request)
    {
        $career = Career::create($request->all());
        return new CareerResource($career);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $career = Career::find($id);
        if (!$career) {
            return new CareerResource([]);
        }
        return new CareerResource($career);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCareerRequest $request, Career $career)
    {
        if ($request->method() == 'PUT') {
            return [
                'error' => 'method is not supported!'
            ];
        }

        $career->update($request->all());
        return [
            'success' => 'updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        //
    }
}
