<?php

namespace App\Http\Controllers\Admin;

use App\Models\Evento;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_evento = DB::table('cda_evento')->get();
        return view('admin.evento.index',compact('cda_evento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $TpAS = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpAS')
            ->get();

        $ObjEvento = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','ObjEvento')
            ->get();

        $TrCtr = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TrCtr')
            ->get();

        $Fila = DB::table('cda_filatrab')->get();
        // show the view and pass the nerd to it
        return view('admin.evento.create',[
            'ObjEvento'=>$ObjEvento,
            'TrCtr'=>$TrCtr,
            'TpAS'=>$TpAS,
            'Fila'=>$Fila
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

        Evento::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('evento.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $evento = Evento::find($id);

        $TpAS = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpAS')
            ->get();

        $ObjEvento = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','ObjEvento')
            ->get();

        $TrCtr = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TrCtr')
            ->get();

        $Fila = DB::table('cda_filatrab')->get();
        // show the view and pass the nerd to it
        return view('admin.evento.edit',[
            'Evento'=>$evento,
            'ObjEvento'=>$ObjEvento,
            'TrCtr'=>$TrCtr,
            'TpAS'=>$TpAS,
            'Fila'=>$Fila
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $evento = Evento::findOrFail($id);
        $evento->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('evento.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy($evento)
    {
        $var = Evento::find($evento);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable()
    {
        $cda_evento = Evento::select(['cda_evento.*','Fila.FilaTrabSg','TransfCtr.REGTABNM as TransfCtrNM','ObjEvento.REGTABNM as ObjEventoNM'])
            ->join('cda_regtab  as ObjEvento', 'ObjEvento.REGTABID', '=', 'cda_evento.ObjEventoId')
            ->join('cda_regtab  as TransfCtr', 'TransfCtr.REGTABID', '=', 'cda_evento.TransfCtrId')
            ->leftJoin('cda_filatrab  as Fila', 'Fila.FilaTrabId', '=', 'cda_evento.FilaTrabId')
            ->get();
        ;
        return Datatables::of($cda_evento)
            ->addColumn('action', function ($evento) {

                return '
                <a href="evento/'.$evento->EventoId.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteEvento('.$evento->EventoId.')" class="btn btn-xs btn-danger deleteEvento" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
