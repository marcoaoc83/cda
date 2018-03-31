<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RegTab;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class RegTabController extends Controller
{
    public function index()
    {
        $cda_tabsys = DB::table('cda_tabsys')->get();

        return view('admin.tabsys.index',compact('cda_tabsys'));
    }

    public function getPosts(Request $request)
    {

        $cda_regtab = RegTab::select(['REGTABID', 'REGTABSG', 'REGTABNM', 'REGTABSQL', 'REGTABSQL', 'TABSYSID'])->where('TABSYSID', $request->TABSYSID);

        return Datatables::of($cda_regtab)
            ->make(true);
    }

    public function getEditar(Request $request)
    {
        // get the nerd
        $tabsys = RegTab::find($request['id']);

        // show the view and pass the nerd to it
        return  $tabsys;
    }

    public function postEditar(Request $request, $id)
    {

        $tabsys = RegTab::findOrFail($id);
        $tabsys->REGTABSG       = $request->REGTABSG;
        $tabsys->REGTABNM       = $request->REGTABNM;
        $tabsys->REGTABSQL      = $request->REGTABSQL;
        if($tabsys->save())
            return \response()->json(true);
        return \response()->json(false);

    }

    public function getInserir()
    {

        // show the view and pass the nerd to it
        return view('admin.tabsys.insere',compact('cda_tabsys'));
    }


    public function postInserir(Request $request)
    {
        $data = $request->all();

        if (RegTab::create($data))
         return \response()->json(true);
        return \response()->json(false);

    }

    public function postDeletar($id)
    {
        $tabsys = RegTab::find($id);
        if($tabsys->delete()) {
            return \response()->json(true);
        }else{
            return \response()->json(false);
        }
    }
}
