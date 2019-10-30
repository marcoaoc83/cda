<?php

namespace App\Http\Controllers\admin;

use App\Models\Fila;
use App\Models\ModCom;
use App\Models\ModeloVar;
use App\Models\Parcela;
use App\Models\PsCanal;
use App\Models\RegTab;
use App\Models\RelatorioParametro;
use App\Models\Relatorios;
use App\Models\Tarefas;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
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
        $Tipo =ModCom::all();
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

        $Tipo = ModCom::all();
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
        $FilaTrab=Fila::all();
        return view('admin.relatorios.gerar')->with('Relatorio',$rel)->with('FilaTrab',$FilaTrab);

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

        $fila = Relatorios::find($request->id) ;
        if ($fila) {
            $fila = $fila->toArray();
        }
        return response()->json($fila);
    }


    public function getDadosDataTableParcela(Request $request)
    {
        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }
        ini_set('memory_limit', '-1');
        $limit=100;
        if($request->demo) $limit=5;
        $where=self::filtroParcela($request,$FxAtraso,$FxValor,$arrayFxValor,$arrayFxAtraso);
        if($request->FilaTrabId && $request->FilaTrabId!='null'){
            $where.=' AND cda_roteiro.FILATRABID = '.$request->FilaTrabId;
        }
        if(empty($where) && empty($request->demo)){
            return '0';
        }

        //$group=['cda_parcela.ParcelaId','cda_roteiro.CarteiraId'];
        $group=['cda_parcela.ParcelaId' ];
        if($request->group=='Pes'){
            $group='cda_parcela.PessoaId';
        }
        if($request->group=='IM'){
            $group='cda_inscrmun.InscrMunId';
        }

        $Parcelas = Parcela::select([
            'cda_parcela.*',
            'cda_inscrmun.INSCRMUNNR',
            'cda_inscrmun.INSCRMUNID',
            'cda_pessoa.CPF_CNPJNR',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            DB::raw("datediff(NOW(), VencimentoDt)  as Atraso"),
            'SitPagT.REGTABSG as SitPag',
            'SitCobT.REGTABSG as SitCob',
            'OrigTribT.REGTABSG as OrigTrib',
            'TribT.REGTABSG as Trib',
            'cda_carteira.CARTEIRASG as Carteira',
            'cda_modcom.ModComSg as ModComSg',
            DB::raw("sum(cda_parcela.TotalVr)  as TotalVr2"),
            DB::raw("if(cda_pessoa.PESSOANMRS IS NULL,'Não Informado',cda_pessoa.PESSOANMRS) as Nome"),
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as  TribT', 'TribT.REGTABID', '=', 'cda_parcela.TributoId')
            ->leftjoin('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->leftjoin('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->leftjoin('cda_modcom', 'cda_roteiro.ModComId', '=', 'cda_modcom.ModComId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
            ->leftjoin('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->leftjoin('cda_pcevento', 'cda_pcevento.PARCELAID', '=', 'cda_parcela.ParcelaId')

            ->whereRaw($where)
            ->groupBy($group)
            ->orderBy('cda_parcela.PessoaId')
            ->orderBy('cda_parcela.ParcelaId')
            ->limit($limit) ;


        $i=0;
        $collect=[];
        foreach ($Parcelas->cursor() as $parcela){
            $doc='';
            if(strlen($parcela['CPF_CNPJNR'])==11){
                $doc= self::maskString($parcela['CPF_CNPJNR'],'###.###.###-##');
            }
            if(strlen($parcela['CPF_CNPJNR'])==14){
                $doc= self::maskString($parcela['CPF_CNPJNR'],'##.###.###/####-##');
            }
            $collect[$i]['LancamentoDt']=$parcela['LancamentoDt']->format('d/m/Y');
            $collect[$i]['PESSOANMRS']=$parcela['Nome'];
            $collect[$i]['Modelo']=$parcela['ModComSg'];
            $collect[$i]['Carteira']=$parcela['Carteira'];
            $collect[$i]['SitPag']=$parcela['SitPag'];
            $collect[$i]['PessoaId']=$parcela['PessoaId'];
            $collect[$i]['INSCRMUNNR']=$parcela['INSCRMUNNR'];
            $collect[$i]['INSCRMUNID']=$parcela['INSCRMUNID'];
            $collect[$i]['CPF_CNPJNR']=$doc;
            $collect[$i]['SitCob']=$parcela['SitCob'];
            $collect[$i]['OrigTrib']=$parcela['OrigTrib'];
            $collect[$i]['Trib']=$parcela['Trib'];
            $collect[$i]['LancamentoNr']=$parcela['LancamentoNr'];
            $collect[$i]['ParcelaNr']=$parcela['ParcelaNr'];
            $collect[$i]['TotalVr']=$parcela['TotalVr'];
            $collect[$i]['PrincipalVr']=$parcela['PrincipalVr'];
            $collect[$i]['Honorarios']=$parcela['Honorarios'];
            $collect[$i]['DescontoVr']=$parcela['DescontoVr'];
            $collect[$i]['MultaVr']=$parcela['MultaVr'];
            $collect[$i]['JurosVr']=$parcela['JurosVr'];
            $collect[$i]['TaxaVr']=$parcela['TaxaVr'];
            $collect[$i]['AcrescimoVr']=$parcela['AcrescimoVr'];
            $collect[$i]['PlanoQt']=$parcela['PlanoQt'];
            $collect[$i]['VencimentoDt']=$parcela['VencimentoDt']->format('d/m/Y');
            $collect[$i]['TotalVr2']="R$ ".number_format($parcela['TotalVr2'],2,',','.');
            $collect[$i]['FxAtraso']=$FxAtraso?$arrayFxAtraso[$FxAtraso[$parcela['PessoaId']]]['Desc']:'';
            if($request->group=='IM'){
                $collect[$i]['FxAtraso']=$FxAtraso?$arrayFxAtraso[$FxAtraso[$parcela['InscrMunId']]]['Desc']:'';
            }
            $collect[$i]['FxValor']=$FxValor?$arrayFxValor[$FxValor[$parcela['PessoaId']]]['Desc']:'';
            if($request->group=='IM'){
                $collect[$i]['FxValor']=$FxValor?$arrayFxValor[$FxValor[$parcela['InscrMunId']]]['Desc']:'';
            }
            $collect[$i]['ParcelaId']=$parcela['ParcelaId'];
            $i++;
        }

        $collect = collect($collect);
        $Relatorios=Relatorios::find($request->rel_id);
        $Modelo=ModCom::find($Relatorios->rel_saida);
        $html=$Modelo->ModTexto;
        $lines=explode(PHP_EOL, $html);
        $html=$lines[1];
        if(empty($lines[1])) $html=$lines[0];
        $regTab=RegTab::find($Modelo->TpModId);
        $type=$regTab->REGTABSGUSER;
        if($request->demo) {
            $type="html";
        }

        $res="";

        $res.=($this->geraModelo($collect,$html));



            $targetpath=storage_path("../public/export");
            $file=md5(uniqid(rand(), true));
            if($type='pdf'){
                $csv = App::make('dompdf.wrapper');
                $csv->setPaper('b3')
                    ->setWarnings(false)
                    ->loadHTML($res);

                $csv->save($targetpath.'/'.$file.'.'.$type);
            }else {
                $dados[]=explode(';',$res);
                $csv = Excel::create($file, function ($excel) use ($dados) {
                    $excel->sheet('mySheet', function ($sheet) use ($dados) {
                        $sheet->fromArray($dados, false, 'A1', false, false);
                    });
                })->store($type, $targetpath);
            }

        if($request->demo) {

            $response = array(
                "success" => true,
                "url" =>URL::to('/') . "/export/" . $file . ".html",
                "file"=>$csv
            );
            echo json_encode($response);
            die();
        }else{
            if($collect->count()==0) return '0';
              Tarefas::create([
                'tar_categoria' => 'execfilaParcela',
                'tar_titulo' => 'Geração de ' . $Relatorios->rel_titulo,
                'tar_user' => auth()->id(),
                'tar_inicio' => date("Y-m-d H:i:s"),
                'tar_final' => date("Y-m-d H:i:s"),
                'tar_descricao' => "<h6><a href='" . URL::to('/') . "/export/" . $file . ".$type' target='_blank'>Arquivo</a></h6>",
                'tar_status' => 'Finalizado'
            ]);
            echo true;
            //return response()->json("<h6><a href='" . URL::to('/') . "/export/" . $file . ".csv' target='_blank'>Arquivo</a></h6>");
        }



    }
    private function filtroParcela($request,&$FxAtraso,&$FxValor,&$arrayFxValor,&$arrayFxAtraso){
        $where=' `cda_pcrot`.`SaidaDt` IS NULL ';

        $limit=100000;
        if($request->limit!=null){
            $limit=$request->limit;
        }


        if($request->roteirosId){
            $where.=' AND cda_roteiro.RoteiroId IN ('.implode(',',$request->roteirosId).')';
        }

        if($request->CARTEIRAID){
            $where.=' AND cda_roteiro.CarteiraId IN ('.implode(',',$request->CARTEIRAID).')';
        }

        if($request->VencimentoInicio){
            $request->VencimentoInicio=Carbon::createFromFormat('d/m/Y', $request->VencimentoInicio)->format('Y-m-d');
            $where.=" AND cda_parcela.VencimentoDt >='".$request->VencimentoInicio."'";
        }

        if($request->VencimentoFinal){
            $request->VencimentoFinal=Carbon::createFromFormat('d/m/Y', $request->VencimentoFinal)->format('Y-m-d');
            $where.=" AND cda_parcela.VencimentoDt <='".$request->VencimentoFinal."'";
        }

        if($request->ContribuinteId){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',$request->ContribuinteId).')';
        }

        if($request->ContribuinteResId){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',$request->ContribuinteResId).')';
        }

        if($request->IMRes){
            $where.=' AND cda_parcela.InscrMunId IN ('.implode(',',$request->IMRes).')';
        }

        if($request->SitPagId){
            $where.=' AND cda_parcela.SitPagId IN ('.implode(',',$request->SitPagId).')';
        }

        if($request->SitCobId){
            $where.=' AND cda_parcela.SitCobId IN ('.implode(',',$request->SitCobId).')';
        }

        if($request->TributoId){
            $where.=' AND cda_parcela.TributoId IN ('.implode(',',$request->TributoId).')';
        }

        if($request->OrigTribId){
            $where.=' AND cda_parcela.OrigTribId IN ('.implode(',',$request->OrigTribId).')';
        }

        if($request->filtro_contribuinteC && empty($request->filtro_contribuinteS)){
            $where.=' AND cda_pessoa.CPF_CNPJNR >1';
        }
        if($request->filtro_contribuinteS && empty($request->filtro_contribuinteC)){
            $where.=' AND cda_pessoa.CPF_CNPJNR < 1';
        }
        if($request->filtro_contribuinteN){
            $where.=' AND cda_pessoa.CPF_CNPJNR ='.$request->filtro_contribuinteN;
        }

        if($request->filtro_contribuinteC2 && empty($request->filtro_contribuinteS)){
            $where.=' AND cda_inscrmun.INSCRMUNNR >1';
        }
        if($request->filtro_contribuinteS2 && empty($request->filtro_contribuinteC2)){
            $where.=' AND cda_inscrmun.INSCRMUNNR < 1';
        }
        if($request->filtro_contribuinteN2){
            $where.=' AND cda_inscrmun.INSCRMUNNR ='.$request->filtro_contribuinteN2;
        }

        $Pessoas = Parcela::select([

            DB::raw("Distinct cda_parcela.ParcelaId"),
            'cda_parcela.PessoaId'
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->leftjoin('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->leftjoin('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
            ->leftjoin('cda_pscanal',  function($join)
            {
                $join->on('cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId');
                $join->on( 'cda_roteiro.CanalId', '=', 'cda_pscanal.CanalId');
                $join->where('cda_pscanal.Ativo','=', 1);
            })
            ->whereRaw($where)
            ->groupBy('cda_parcela.PessoaId','cda_parcela.ParcelaId')
            ->limit($limit);

        foreach ($Pessoas->cursor() as $pess){
            $parc[]=$pess->ParcelaId;
        }

        $grp="cda_parcela.PessoaId";
        if($request->group=='IM'){
            $grp="cda_parcela.InscrMunId";
        }

        if($parc) {
            $where.=" AND cda_parcela.ParcelaId IN (".implode(',',$parc).")";
            $Pessoas = Parcela::select([
                DB::raw("Distinct cda_parcela.ParcelaId"),
                'cda_parcela.PessoaId',
                'cda_parcela.InscrMunId',
                DB::raw("datediff(NOW(), MIN(VencimentoDt))  as MAX_VENC"),
                DB::raw("SUM(TotalVr)  as Total"),
                DB::raw("COUNT(cda_parcela.ParcelaId)  as Qtde"),
            ])
                ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
                ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
                ->leftjoin('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
                ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
                ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
                ->where('cda_parcela.SitPagId', '61')
                ->whereRaw($where)
                ->groupBy($grp)
                ->get();
        }else{
            return false;
        }

        $arrayFxAtraso=[];

        if($request->FxAtrasoId){
            $regtab=RegTab::whereRaw(' REGTABID IN ('.implode(',',$request->FxAtrasoId).')')->get();
        }else{
            $regtab= RegTab::where('TABSYSID',32)->get();
        }

        foreach ($regtab as $value){
            $fxa=explode('*',$value['REGTABSQL']);
            $arrayFxAtraso[$value['REGTABID']]['Min']=$fxa[0] ;
            $arrayFxAtraso[$value['REGTABID']]['Max']= isset($fxa[1])?$fxa[1]:null;
            $arrayFxAtraso[$value['REGTABID']]['Desc']= $value['REGTABSG'];
        }

        $arrayFxValor=[];

        if($request->FxValorId) {
            $regtab = RegTab::whereRaw(' REGTABID IN (' . implode(',', $request->FxValorId) . ')')->get();
        }else{
            $regtab= RegTab::where('TABSYSID',33)->get();
        }

        foreach ($regtab as $value){
            $fxa=explode('*',$value['REGTABSQL']);
            $arrayFxValor[$value['REGTABID']]['Min']=$fxa[0] ;
            $arrayFxValor[$value['REGTABID']]['Max']=isset($fxa[1])?$fxa[1]:null;
            $arrayFxValor[$value['REGTABID']]['Desc']= $value['REGTABSG'];
        }

        $FxAtraso=$FxValor=$seqValor=$Nqtde=[];

        foreach ($Pessoas as $pessoa){

            foreach ($arrayFxAtraso as $key=>$value){
                if($pessoa['MAX_VENC']>$value['Min']){
                    if($value['Max']){
                        if($pessoa['MAX_VENC']<=$value['Max']){
                            if($request->group=='IM'){
                                $FxAtraso[$pessoa['InscrMunId']]=$key;
                            }else{
                                $FxAtraso[$pessoa['PessoaId']]=$key;
                            }
                        }
                    }else{
                        if($request->group=='IM'){
                            $FxAtraso[$pessoa['InscrMunId']]=$key;
                        }else{
                            $FxAtraso[$pessoa['PessoaId']]=$key;
                        }
                    }
                }
            }

            foreach ($arrayFxValor as $key=>$value){
                if($pessoa['Total']>$value['Min']){
                    if($value['Max']){
                        if($pessoa['Total']<=$value['Max']){
                            if($request->group=='IM'){
                                $FxValor[$pessoa['InscrMunId']]=$key;
                            }else{
                                $FxValor[$pessoa['PessoaId']]=$key;
                            }
                        }
                    }else{
                        if($request->group=='IM'){
                            $FxValor[$pessoa['InscrMunId']]=$key;
                        }else{
                            $FxValor[$pessoa['PessoaId']]=$key;
                        }
                    }
                }
            }
            if($request->group=='IM'){
                $seqValor[$pessoa['Total']]=$pessoa['InscrMunId'];
            }else{
                $seqValor[$pessoa['Total']]=$pessoa['PessoaId'];
            }

        }

        if($request->nmaiores){
            krsort($seqValor);
            foreach ($seqValor as $pess){
                $seqValor2[]=$pess;
            }
            for($x=0;$x<$request->nmaiores;$x++){
                $Nqtde[]=$seqValor2[$x];
            }
        }

        if($request->nmenores){
            ksort($seqValor);
            foreach ($seqValor as $pess){
                $seqValor3[]=$pess;
            }
            for($x=0;$x<$request->nmenores;$x++){
                $Nqtde[]=$seqValor3[$x];
            }
        }

        $wIM=$wPes=[];
        if($FxAtraso){
            if($request->group=='IM') {
                $wIM+=$FxAtraso;
                //$where .= ' AND cda_parcela.InscrMunId IN (' . implode(',', array_keys($FxAtraso)) . ')';
            }else{
                $wPes+=$FxAtraso;
                //$where .= ' AND cda_parcela.PessoaId IN (' . implode(',', array_keys($FxAtraso)) . ')';
            }
        }elseif($request->FxAtrasoId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
        }

        if($FxValor){
            if($request->group=='IM') {
                $wIM+=$FxValor;
                //$where .= ' AND cda_parcela.InscrMunId IN (' . implode(',', array_keys($FxValor)) . ')';
            }else{
                $wPes+=$FxValor;
                // $where .= ' AND cda_parcela.PessoaId IN (' . implode(',', array_keys($FxValor)) . ')';
            }
        }elseif($request->FxValorId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
        }

        if($Nqtde){
            if($request->group=='IM') {
                $wIM+=$Nqtde;
                //$where .= ' AND cda_parcela.InscrMunId IN (' .implode(',',$Nqtde).')';
            }else{
                $wPes+=$Nqtde;
                // $where .= ' AND cda_parcela.PessoaId IN (' .implode(',',$Nqtde).')';
            }
        }
        if($wIM) $where .= ' AND cda_parcela.InscrMunId IN (' . implode(',', array_keys($wIM)) . ')';
        if($wPes) $where .= ' AND cda_parcela.PessoaId IN (' . implode(',', array_keys($wPes)) . ')';
        return $where;
    }

    /**
     * Função para mascarar uma string, mascara tipo ##-##-##
     *
     * @param string $val
     * @param string $mask
     *
     * @return string
     */
    public static function maskString($val, $mask)
    {
        if (empty($val)) {
            return $val;
        }
        $maskared = '';
        $k = 0;
        if (is_numeric($val)) {
            $val = sprintf('%0' . mb_strlen(preg_replace('/[^#]/', '', $mask)) . 's', $val);
        }
        for ($i = 0; $i <= mb_strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }

        return $maskared;
    }

    function geraModelo($pessoa,$html){

        $Variaveis=RegTab::where('TABSYSID',46)->where('REGTABSG', 'like',  'rel%')->get();

        $x=0;
        foreach ($Variaveis as $var){

            $vs=explode("*=",$var->REGTABSQL);
            $key=$vs[0];
            if(!$key) continue;
            $replace[$key][$x]['sg']=$var['REGTABSG'];
            $replace[$key][$x]['campo']=$vs[1]??null;
            $x++;
        }
        $result=[];
        $i=1;
        foreach ($pessoa as $linha) {


            foreach ($replace as $tipo => $campo) {
                foreach ($campo as  $campos) {
                    $sg = $campos['sg'];
                    $campo = $campos['campo'];
                    switch ($tipo) {
                        case "fixo":
                            $result[$i][$sg] = $campo;
                            break;
                        case "data":
                            if (isset($linha[$campo])) {
                                $valor = Carbon::createFromFormat('Y-m-d', $linha[$campo])->format('d/m/Y');
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "numero":
                            if (isset($linha[$campo])) {
                                $valor = number_format($linha[$campo], 2, ',', '.');
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "texto":
                            if (isset($linha[$campo])) {
                                $valor = $linha[$campo];
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "textoFirst":
                            if (isset($linha[$campo])) {
                                $valor = explode(' ',$linha[$campo]);
                                $result[$i][$sg] = trim($valor[0]);
                            }
                            break;
                        case "array":
                            if (isset($linha[$campo])) {
                                $valor = $linha[$campo];
                                if (strpos($valor, '-') !== false) {
                                    //$valor = Carbon::createFromFormat('Y-m-d', $linha[$campo])->format('d/m/Y');
                                }
                                $result[$i][self::soLetra($sg) . $i] = $valor;
                            }
                            break;
                        case "arrayNumber":
                            if (isset($linha[$campo])) {
                                $valor = $linha[$campo];
                                if(is_numeric($valor))
                                    $valor =number_format($valor, 2, ',', '.');
                                $result[$i][self::soLetra($sg) . $i] = $valor;
                            }
                            break;
                        case "soma":
                            if (isset($linha[$campo])) {
                                if (isset($result[$i - 1][$sg])) {
                                    $valor = $result[$i - 1][$sg] + $linha[$campo];
                                    unset($result[$i - 1][$sg]);
                                } else {
                                    $valor = $linha[$campo];
                                }

                                $result[$i][$sg] = $valor;
                            }
                            break;
                    }
                }
                // }
            }
            $i++;
        }
        foreach ($result as $campos) {
            foreach ($campos as $key=>$val) {
                $sg = "{{" . $key . "}}";
                $value = $val;
                $html = str_replace($sg,$value, $html);
            }
        }

        return $html;

    }
    private function soLetra($str) {
        return preg_replace("/[^A-Za-z]/", "", $str);
    }


    public function getDadosDataTableCanal(Request $request)
    {
        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }

        $where=1;
        if($request->ValEnvId && !$request->TratRetId){
            $where.=' AND  cda_valenv.ValEnvId IN ('.implode(',',$request->ValEnvId).')';
        }
        if($request->TratRetId && !$request->ValEnvId){
            $where.=' AND  cda_tratret.TratRetId IN ('.implode(',',$request->TratRetId).')';
        }
        if($request->TratRetId && $request->ValEnvId){
            $where.=' AND ( cda_valenv.ValEnvId IN ('.implode(',',$request->ValEnvId).')';
            $where.=' or  cda_tratret.TratRetId IN ('.implode(',',$request->TratRetId).'))';
        }
        if($request->Canal){
            $where.=" AND cda_pscanal.CanalId = '$request->Canal'";
        }
        if($request->ContribuinteResId){
            $where.=' AND cda_pessoa.PessoaId IN ('.implode(',',$request->ContribuinteResId).')';
        }
        if($request->ContribuinteResIMId && ($request->group!='IM')){
            $where.=' AND cda_pscanal.InscrMunId IN ('.implode(',',$request->ContribuinteResIMId).')';
        }
        if($request->FilaTrabId && $request->FilaTrabId!='null'){
            $where.=' AND cda_roteiro.FILATRABID = '.$request->FilaTrabId;
        }
        $Validacao=[];
        $x=0;
        $pscanais = PsCanal::select([
            'cda_pscanal.PsCanalId',
            'cda_pscanal.PessoaId',
            'cda_pscanal.InscrMunId',
            'cda_pscanal.FonteInfoId',
            'cda_pscanal.CanalId',
            'cda_pscanal.TipPosId',
            'cda_pscanal.CEP',
            'cda_pscanal.LogradouroId',
            'cda_pscanal.EnderecoNr',
            'cda_pscanal.Complemento',
            'cda_pscanal.TelefoneNr',
            'cda_pscanal.Email',
            'cda_pscanal.BairroId',
            'cda_pscanal.CidadeId',

            'FonteInfoId.REGTABSG as FonteInfo',
            'TipPosId.REGTABNM as TipPos',
            'cda_canal.CANALSG',
            'cda_inscrmun.INSCRMUNID',
            'cda_inscrmun.INSCRMUNNR',
            'cda_pessoa.PESSOANMRS as Nome',
            'cda_pessoa.CPF_CNPJNR as Documento',
            'cda_evento.*',
            DB::raw('IF(cda_pscanal.LogradouroId IS NOT NULL , CONCAT_WS(" ",cda_logradouro.logr_tipo,cda_logradouro.logr_nome),cda_pscanal.Logradouro) AS Logradouro'),
            DB::raw('IF(cda_pscanal.BairroId IS NOT NULL ,cda_bairro.bair_nome,cda_pscanal.Bairro) AS Bairro'),
            DB::raw('IF(cda_pscanal.CidadeId IS NOT NULL , cda_cidade.cida_nome,cda_pscanal.Cidade) AS Cidade'),
            DB::raw('IF(cda_cidade.cida_uf IS NOT NULL , cda_cidade.cida_uf,cda_pscanal.UF) AS UF')
        ])
            ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
            ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
            ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
            ->leftjoin('cda_logradouro', 'cda_logradouro.logr_id', '=', 'cda_pscanal.LogradouroId')
            ->leftjoin('cda_bairro', 'cda_bairro.bair_id', '=', 'cda_pscanal.BairroId')
            ->leftjoin('cda_cidade', 'cda_cidade.cida_id', '=', 'cda_pscanal.CidadeId')
            ->leftjoin('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_pscanal.PessoaId')
            ->leftjoin('cda_canal_fila', 'cda_canal_fila.cafi_pscanal', '=', 'cda_pscanal.PsCanalId')
            ->leftjoin('cda_evento','cda_evento.EventoId','=','cda_canal_fila.cafi_evento')
            ->leftjoin('cda_valenv','cda_valenv.EventoId','=','cda_evento.EventoId')
            ->leftjoin('cda_tratret','cda_tratret.EventoId','=','cda_evento.EventoId');
             if($request->FilaTrabId && $request->FilaTrabId!='null')
                 $pscanais->where('cda_canal_fila.cafi_fila',$request->FilaTrabId);

            $pscanais->whereRaw($where);

            $pscanais->groupBy('cda_pscanal.PsCanalId');


        //error_log(print_r($pscanais,1));

        foreach ($pscanais->cursor() as $dado){

            $Dados=$dado->logradouro.' '.$dado->EnderecoNr.' '.$dado->Bairro.' '.$dado->Cidade.' '.$dado->UF.' '.$dado->cep.' '.$dado->Email.' '.$dado->TelefoneNr;
            $Validacao[$x][$x]['PessoaId']=$dado->PessoaId;
            $Validacao[$x][$x]['PsCanalId']=$dado->PsCanalId;
            $Validacao[$x][$x]['EventoId']=$dado->EventoId;
            $Validacao[$x][$x]['Evento']=$dado->EventoSg;
            $Validacao[$x][$x]['Nome']=$dado->Nome;
            $Validacao[$x][$x]['Documento']=$dado->Documento;
            $Validacao[$x][$x]['INSCRMUNID']=$dado->InscrMunId;
            $Validacao[$x][$x]['INSCRMUNNR']=$dado->InscrMunNr;
            $Validacao[$x][$x]['Canal']=$dado->CanalSg;
            $Validacao[$x][$x]['TipoPos']=$dado->TipPos;
            $Validacao[$x][$x]['Fonte']=$dado->FonteInfo;
            $Validacao[$x][$x]['Dados']=trim($Dados);
            $x++;
        }
        if($request->group=='Pes'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['PessoaId']]['PessoaId']=$value['PessoaId'];
                $tempValidacao[$value['PessoaId']]['Nome']=$value['Nome'];
                $tempValidacao[$value['PessoaId']]['CPFCNPJ']=$value['Documento'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        if($request->group=='IM'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNID']=$value['INSCRMUNID'];
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNNR']=$value['INSCRMUNNR'];
                $tempValidacao[$value['INSCRMUNID']]['Nome']=$value['Nome'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        $collect = collect($Validacao);


        $Relatorios=Relatorios::find($request->rel_id);
        $Modelo=ModCom::find($Relatorios->rel_saida);
        $html=$Modelo->ModTexto;
        $lines=explode(PHP_EOL, $html);
        $html=$lines[1];
        if(empty($lines[1])) $html=$lines[0];
        $regTab=RegTab::find($Modelo->TpModId);
        $type=$regTab->REGTABSGUSER;
        if($request->demo) {
            $type="html";
        }

        $texto=[];
        foreach ($collect as $linha){
            $res=($this->geraModelo($linha,$html));
            $dados[]=explode(';',$res);
        }

        $targetpath=storage_path("../public/export");
        $file=md5(uniqid(rand(), true));
        $csv= Excel::create($file, function($excel) use ($dados) {
            $excel->sheet('mySheet', function($sheet) use ($dados)
            {
                $sheet->fromArray($dados,false,'A1',false,false);
            });
        })->store($type,$targetpath);

        if($request->demo) {

            $response = array(
                "success" => true,
                "url" =>URL::to('/') . "/export/" . $file . ".html",
                "file"=>$csv
            );
            echo json_encode($response);
            die();
        }else{
            if($collect->count()==0) return '0';
            Tarefas::create([
                'tar_categoria' => 'relatorioCanal',
                'tar_titulo' => 'Geração de ' . $Relatorios->rel_titulo,
                'tar_user' => auth()->id(),
                'tar_inicio' => date("Y-m-d H:i:s"),
                'tar_final' => date("Y-m-d H:i:s"),
                'tar_descricao' => "<h6><a href='" . URL::to('/') . "/export/" . $file . ".$type' target='_blank'>Arquivo</a></h6>",
                'tar_status' => 'Finalizado'
            ]);
            echo true;
            //return response()->json("<h6><a href='" . URL::to('/') . "/export/" . $file . ".csv' target='_blank'>Arquivo</a></h6>");
        }

    }
}
