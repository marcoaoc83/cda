<?php

namespace App\Http\Controllers\Admin;


use App\Models\Carteira;
use App\Models\Fila;
use App\Models\FilaCarteira;
use App\Models\FilaRoteiro;
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
            ->orderBy('cda_regtab.REGTABSG','asc')
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
        $request->filtro_carteira?$request->filtro_carteira=1:$request->filtro_carteira=0;
        $request->filtro_roteiro?$request->filtro_roteiro=1:$request->filtro_roteiro=0;
        $request->filtro_contribuinte?$request->filtro_contribuinte=1:$request->filtro_contribuinte=0;
        $request->filtro_parcelas?$request->filtro_parcelas=1:$request->filtro_parcelas=0;
        $request->resultado_contribuinte?$request->resultado_contribuinte=1:$request->resultado_contribuinte=0;
        $request->resultado_im?$request->resultado_im=1:$request->resultado_im=0;
        $request->resultado_parcelas?$request->resultado_parcelas=1:$request->resultado_parcelas=0;

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
            ->orderBy('cda_regtab.REGTABSG','asc')
            ->get();

        $Evento = DB::table('cda_evento')->get();


        $DiaSem = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','DiaSem')
            ->get();


        $RegTab = DB::table('cda_regtab')->get();

        $TabTab = DB::table('cda_tabsys')->get();
        $FilaCarteira = FilaCarteira::select('fixca_carteira')->where('fixca_fila',$id)->get();
        $FilaRoteiro = FilaRoteiro::select('fixro_roteiro')->where('fixro_fila',$id)->get();

        // show the view and pass the nerd to it
        return view('admin.fila.edit',[
            'Evento'=>$Evento,
            'TpMod'=>$TpMod,
            'DiaSem'=>$DiaSem,
            'RegTab'=>$RegTab,
            'TabTab'=>$TabTab,
            'FilaCarteira'=>$FilaCarteira,
            'FilaRoteiro'=>$FilaRoteiro,
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

        $request->filtro_carteira?$request->filtro_carteira=1:$request->filtro_carteira=0;
        $request->filtro_roteiro?$request->filtro_roteiro=1:$request->filtro_roteiro=0;
        $request->filtro_contribuinte?$request->filtro_contribuinte=1:$request->filtro_contribuinte=0;
        $request->filtro_parcelas?$request->filtro_parcelas=1:$request->filtro_parcelas=0;
        $request->resultado_contribuinte?$request->resultado_contribuinte=1:$request->resultado_contribuinte=0;
        $request->resultado_im?$request->resultado_im=1:$request->resultado_im=0;
        $request->resultado_parcelas?$request->resultado_parcelas=1:$request->resultado_parcelas=0;

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

    public function getDadosCarteira()
    {
        $cda_carteira = Carteira::select(['CARTEIRAID','CARTEIRAORD','CARTEIRASG', 'CARTEIRANM'])->orderBy('CARTEIRAORD');

        return Datatables::of($cda_carteira)
            ->addColumn('action', function ($carteira) {

                return '
                <a href="carteira/'.$carteira->CARTEIRAID.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteCarteira('.$carteira->CARTEIRAID.')" class="btn btn-xs btn-danger deleteCarteira" >
                    <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
