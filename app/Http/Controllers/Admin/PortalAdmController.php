<?php

namespace App\Http\Controllers\Admin;

use App\Models\PortalAdm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;

class PortalAdmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();

        return view('admin.portal.index')->with('Var',$Var[0]);
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
        $data = $request->all();
        DB::table('cda_portal')->update($request->except([
            '_token',
            'port_logo_topoTmp',
            'port_logo_rodapeTmp',
            'port_banner_lateralTmp',
            'port_banner1Tmp',
            'port_banner2Tmp',
            'port_banner3Tmp',
            'port_banner4Tmp',
            'port_banner5Tmp'
        ]));
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('portal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function show(PortalAdm $portalAdm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function edit(PortalAdm $portalAdm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PortalAdm $portalAdm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortalAdm $portalAdm)
    {
        //
    }
}
