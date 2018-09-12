<?php

namespace App\Http\Controllers\admin;

use App\Models\RelatorioParametro;
use App\Models\Relatorios;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
    public function getdataRegistroSql(Request $request)
    {
        $sql=$request->sql;

        $parametros=RelatorioParametro::where("rep_rel_id",$request->rel_id)->get();
        $where=" WHERE 1";
        foreach ($parametros as $p){
            $c=$p->rep_parametro;
            if($request->$c){
                $vl=$request->$c;
                if($p->rep_tipo=='data'){
                    $vl=Carbon::createFromFormat('d/m/Y', $vl)->format('Y-m-d');
                }
                $sw=str_replace("**","'$vl'",$p->rep_valor);

                $where.=" AND $sw";
            }
        }
        $sql.=$where;

        return  str_replace("\r\n","", $sql);
    }
    public function getdataRegistro(Request $request)
    {

        $sql=$request->sql;

        $parametros=RelatorioParametro::where("rep_rel_id",$request->rel_id)->get();
        $where=" WHERE 1";
        foreach ($parametros as $p){
            $c=$p->rep_parametro;
            if($request->$c){
                $vl=$request->$c;
                if($p->rep_tipo=='data'){
                    $vl=Carbon::createFromFormat('d/m/Y', $vl)->format('Y-m-d');
                }
                $sw=str_replace("**","'$vl'",$p->rep_valor);

                $where.=" AND $sw";
            }
        }
        $sql.=$where;
        if(isset($request->limit))
            $sql.=' LIMIT '.$request->limit;

        $res = DB::select($sql);

        return Datatables::of($res)
            ->make(true);

    }

    public function export(Request $request)
    {

        if($request->tipo == "csv"){
            return self::exportCSV($request->sql);
        }
        if($request->tipo == "txt"){
            return self::exportTXT($request->sql);
        }
//        if($request->tipo == "pdf"){
//            return self::exportPDF($request->sql);
//        }
    }

    public function exportPDF($sql)
    {
        ini_set('max_execution_time', 500);
        $data = DB::select($sql)->get();
        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('admin.relatorio.export',  compact('data'));
        // If you want to store the generated pdf to the server then you can use the store function
        //$pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function
        $pdf->setOptions(['dpi' => 30, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('pessoa.pdf');
    }

    public function exportCSV($sql)
    {
        $data = DB::select($sql);
        return Excel::create('report', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                foreach ($data as &$dt) {
                    $dt = (array)$dt;
                }
                $sheet->fromArray($data);
            });
        })->download("csv");
    }

    public function exportTXT($sql)
    {
        $data = DB::select($sql)->get()->toArray();
        return Excel::create('report', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download("txt");
    }
}
