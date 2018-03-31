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

    public function getEditar($id)
    {
        // get the nerd
        $tabsys = RegTab::find($id);

        // show the view and pass the nerd to it
        return View::make('admin.tabsys.form')
            ->with('tabsys', $tabsys);
    }

    public function postEditar(Request $request, $id)
    {

        if  ($request->TABSYSSQL) {
            $request->TABSYSSQL      =1;
        }else{
            $request->TABSYSSQL      =0;
        }


        $tabsys = RegTab::findOrFail($id);
        $tabsys->TABSYSSG       = $request->TABSYSSG;
        $tabsys->TABSYSNM       = $request->TABSYSNM;
        $tabsys->TABSYSSQL      = $request->TABSYSSQL;
        $tabsys->save();
        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('admin.tabsys');

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
