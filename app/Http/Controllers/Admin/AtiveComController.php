<?php

namespace App\Http\Controllers\Admin;

use App\Models\AtiveCom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AtiveComController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AtiveCom  $ativeCom
     * @return \Illuminate\Http\Response
     */
    public function show(AtiveCom $ativeCom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AtiveCom  $ativeCom
     * @return \Illuminate\Http\Response
     */
    public function edit(AtiveCom $ativeCom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AtiveCom  $ativeCom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AtiveCom $ativeCom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AtiveCom  $ativeCom
     * @return \Illuminate\Http\Response
     */
    public function destroy(AtiveCom $ativeCom)
    {
        //
    }

    public function getDadosDataTable(Request $request)
    {
        return;
    }
}
