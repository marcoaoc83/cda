<?php

namespace App\Http\Controllers\Admin;


use App\Models\Fila;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FilaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_filatrab = DB::table('cda_filatrab')->get();
        return view('admin.fila.index',compact('cda_filatrab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $TpMod = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpMod')
            ->get();
        ;
        $Evento = DB::table('cda_evento')
            ->get();
        ;

        // show the view and pass the nerd to it
        return view('admin.fila.create',[
            'TpMod'=>$TpMod,
            'Evento'=>$Evento
        ]);
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

        Fila::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('fila.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fila  $fila
     * @return \Illuminate\Http\Response
     */
    public function show(Fila $fila)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fila  $fila
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $fila = Fila::find($id);

        $TpMod = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpMod')
            ->get();
        ;
        $Evento = DB::table('cda_evento')->get();
        ;

        // show the view and pass the nerd to it
        return view('admin.fila.edit',[
            'Evento'=>$Evento,
            'TpMod'=>$TpMod,
            'Fila'=>$fila
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fila  $fila
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $evento = Fila::findOrFail($id);
        $evento->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('fila.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fila  $fila
     * @return \Illuminate\Http\Response
     */
    public function destroy($fila)
    {
        $var = Fila::find($fila);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable()
    {
        $cda_fila = Fila::select(['FilaTrabId','FilaTrabSg', 'FilaTrabNm']);

        return Datatables::of($cda_fila)
            ->addColumn('action', function ($fila) {

                return '
                <a href="fila/'.$fila->FilaTrabId.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteFila('.$fila->FilaTrabId.')" class="btn btn-xs btn-danger deleteFila" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
