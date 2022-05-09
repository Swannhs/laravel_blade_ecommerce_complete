<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportsController extends Controller
{

    public function index()
    {
        return view('seller::reports.index');
    }


    public function create()
    {
        return view('seller::create');
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        return view('seller::show');
    }


    public function edit($id)
    {
        return view('seller::edit');
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
