<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tarefas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class TarefasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tarefas.index');
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
     * @param  \App\Models\Tarefas  $tarefas
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefas $tarefas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefas  $tarefas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefas $tarefas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefas  $tarefas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefas $tarefas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefas  $tarefas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefas $tarefas)
    {
        //
    }


    public function getDadosDataTable(Request $request)
    {
        $table = Tarefas::select(['*'])
            ->leftjoin('jobs', 'jobs.id', '=', 'cda_tarefas.tar_id')
            ->orderBy('tar_id','DESC')
        ->get();


        return Datatables::of($table)
            ->addColumn('action',
                function ($table) {
                    $bt="";
                    if($table->tar_status=="Aguardando"){
                    $bt='<a href="javascript:;" onclick="execTarefa(\''.strtolower($table->tar_categoria).'\','.$table->tar_id.')" class="btn btn-xs btn-primary" >
                        <i class="fa fa-play-circle"></i> Executar
                        </a>';
                    }
                    return  '
                         <input type="hidden" id="tar_desc'.$table->tar_id.'"  value="'.$table->tar_descricao.'">
                        <a href="javascript:;" onclick="verTarefa('.$table->tar_id.');$(this).hide();" class="btn btn-xs btn-info" >
                        <i class="glyphicon glyphicon-plus-sign"></i> Detalhes
                        </a>
                        
                        '.$bt;
                })
            ->make(true);
    }
}
