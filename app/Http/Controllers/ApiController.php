<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller {

    protected $services;

    public function index(Request $request) {
        return $this->services->index($request);        
    }

    public function show($id) {
        return $this->services->show($id);        
    }

    public function store(Request $request) {
        return $this->services->store($request);
    }

    public function update(Request $request, $id) {
        return $this->services->update($request, $id);
    }

    public function destroy($id) {
        return $this->services->destroy($id);
    }

    public function options(Request $request) {
        return $this->services->options($request->all());
    }

}