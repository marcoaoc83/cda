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
        $data = $request->all();
        $data['filtro_carteira']?$data['filtro_carteira']=1:$data['filtro_carteira']=0;
        $data['filtro_roteiro']?$data['filtro_roteiro']=1:$data['filtro_roteiro']=0;
        $data['filtro_contribuinte']?$data['filtro_contribuinte']=1:$data['filtro_contribuinte']=0;
        $data['filtro_parcelas']?$data['filtro_parcelas']=1:$data['filtro_parcelas']=0;
        $data['filtro_validacao']?$data['filtro_validacao']=1:$data['filtro_validacao']=0;
        $data['filtro_eventos']?$data['filtro_eventos']=1:$data['filtro_eventos']=0;
        $data['filtro_tratamento']?$data['filtro_tratamento']=1:$data['filtro_tratamento']=0;
        $data['filtro_notificacao']?$data['filtro_notificacao']=1:$data['filtro_notificacao']=0;
        $data['filtro_canal']?$data['filtro_canal']=1:$data['filtro_canal']=0;

        $data['resultado_contribuinte']?$data['resultado_contribuinte']=1:$data['resultado_contribuinte']=0;
        $data['resultado_im']?$data['resultado_im']=1:$data['resultado_im']=0;
        $data['resultado_parcelas']?$data['resultado_parcelas']=1:$data['resultado_parcelas']=0;
        $data['resultado_canais']?$data['resultado_canais']=1:$data['resultado_canais']=0;

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


        // show the view and pass the nerd to it
        return view('admin.fila.edit',[
            'Evento'=>$Evento,
            'TpMod'=>$TpMod,
            'DiaSem'=>$DiaSem,
            'RegTab'=>$RegTab,
            'TabTab'=>$TabTab,
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



        $data = $request->all();
        $data['filtro_carteira']?$data['filtro_carteira']=1:$data['filtro_carteira']=0;
        $data['filtro_roteiro']?$data['filtro_roteiro']=1:$data['filtro_roteiro']=0;
        $data['filtro_contribuinte']?$data['filtro_contribuinte']=1:$data['filtro_contribuinte']=0;
        $data['filtro_parcelas']?$data['filtro_parcelas']=1:$data['filtro_parcelas']=0;
        $data['filtro_validacao']?$data['filtro_validacao']=1:$data['filtro_validacao']=0;
        $data['filtro_eventos']?$data['filtro_eventos']=1:$data['filtro_eventos']=0;
        $data['filtro_tratamento']?$data['filtro_tratamento']=1:$data['filtro_tratamento']=0;
        $data['filtro_notificacao']?$data['filtro_notificacao']=1:$data['filtro_notificacao']=0;
        $data['filtro_canal']?$data['filtro_canal']=1:$data['filtro_canal']=0;

        $data['resultado_contribuinte']?$data['resultado_contribuinte']=1:$data['resultado_contribuinte']=0;
        $data['resultado_im']?$data['resultado_im']=1:$data['resultado_im']=0;
        $data['resultado_parcelas']?$data['resultado_parcelas']=1:$data['resultado_parcelas']=0;
        $data['resultado_canais']?$data['resultado_canais']=1:$data['resultado_canais']=0;
        $evento = Fila::findOrFail($id);
        $evento->update($data);

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
