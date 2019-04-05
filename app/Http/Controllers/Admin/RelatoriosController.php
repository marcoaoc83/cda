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
    private $tipo=[
        'csv',
        //'pdf',
        'txt'
    ];
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
        $Tipo = collect($this->tipo);
        // show the view and pass the nerd to it
        return view('admin.relatorios.create',compact('Tipo'));
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

        $Tipo = collect($this->tipo);
        // show the view and pass the nerd to it
        return view('admin.relatorios.edit',[ 'Relatorio'=>$Relatorio,'Tipo'=>$Tipo]);
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
        $evento = Relatorios::findOrFail($id);
        $evento->update($data);

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
        $rel=Relatorios::find($id);

        return view('admin.relatorios.gerar')->with('Relatorio',$rel);

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

    public function info(Request $request){

        $fila = Relatorios::find($request->id)->toArray();

        return response()->json($fila);
    }
}
