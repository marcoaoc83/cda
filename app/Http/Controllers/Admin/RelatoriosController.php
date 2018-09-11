<?php

namespace App\Http\Controllers\admin;

use App\Models\Relatorios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class RelatoriosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.relatorios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // show the view and pass the nerd to it
        return view('admin.relatorios.create');
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

        Relatorios::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('relatorios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Relatorios  $relatorios
     * @return \Illuminate\Http\Response
     */
    public function show(Relatorios $relatorios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Relatorios  $relatorios
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Relatorio = Relatorios::find($id);


        // show the view and pass the nerd to it
        return view('admin.relatorios.edit',[ 'Relatorio'=>$Relatorio]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Relatorios  $relatorios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $evento = Relatorios::findOrFail($id);
        $evento->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('relatorios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relatorios  $relatorios
     * @return \Illuminate\Http\Response
     */
    public function destroy( $relatorios)
    {
        $var = Relatorios::find($relatorios);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable()
    {
        $cda_evento = Relatorios::select(['cda_relatorios.*'])->get();

        return Datatables::of($cda_evento)
            ->addColumn('action', function ($relatorio) {

                return '
                <a href="relatorios/'.$relatorio->rel_id.'/gerar" class="btn btn-xs btn-success">
                    <i class="glyphicon glyphicon-list-alt"></i> Gerar
                </a>
                <a href="relatorios/'.$relatorio->rel_id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteRelatorios('.$relatorio->rel_id.')" class="btn btn-xs btn-danger deleteRelatorios" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function gerar($id)
    {
        $rel=Relatorios::with('Parametros')->where('rel_id',$id)->get();

        $sql=explode("where",strtolower($rel[0]->rel_sql));

        $result=DB::select($sql[0]);
        $query=array_map(function ($value) {
            return (array)$value;
        }, $result);
        $campos=(array_keys($query[0]));

        return view('admin.relatorios.gerar')
            ->with('campos',($campos))
            ->with('rel',$rel[0]);

    }

    public function getdataRegistro(Request $request)
    {
        $res = DB::select($request->sql);

        return Datatables::of($res)
            ->make(true);

    }
}
