<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller 
{
    protected $services = null;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->services->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $this->services->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->services->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        return $this->services->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->services->destroy($id);
    }

    /**
     * Get options for select/dropdown
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function options(Request $request)
    {
        return $this->services->options($request);
    }
}