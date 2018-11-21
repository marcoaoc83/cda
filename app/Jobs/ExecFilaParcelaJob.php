<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\ModeloController;
use App\Models\Bairro;
use App\Models\Cidade;
use App\Models\Logradouro;
use App\Models\ModCom;
use App\Models\PcRot;
use App\Models\PrRotCanal;
use App\Models\PsCanal;
use App\Models\RegTab;
use App\Models\Tarefas;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use League\Flysystem\File;
use ZanySoft\Zip\Zip;

class ExecFilaParcelaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $parcelas;
    protected $Tarefa;
    protected $Gravar;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parcelas,$Tarefa,$Gravar)
    {
        $this->parcelas=$parcelas;
        $this->Tarefa=$Tarefa;
        $this->Gravar=$Gravar;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Tarefa= Tarefas::findOrFail($this->Tarefa);
        $Tarefa->update([
            "tar_inicio"    => date("Y-m-d H:i:s")
        ]);

        $dir="filas/tarefa".$this->Tarefa;
        if(!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        $sql="Select
              cda_parcela.PARCELAID,
              cda_parcela.PESSOAID,
              cda_parcela.SITPAGID,
              cda_parcela.SITCOBID,
              cda_parcela.INSCRMUNID,
              cda_parcela.ORIGTRIBID,
              cda_parcela.LancamentoDt,
              cda_parcela.VencimentoDt,
              cda_parcela.TRIBUTOID,
              cda_parcela.PrincipalVr,
              cda_parcela.JurosVr,
              cda_parcela.MultaVr,
              cda_parcela.DescontoVr,
              cda_parcela.Honorarios,
              cda_parcela.TotalVr,
              TRIB.REGTABSG as TRIBUTONM,
              cda_pcrot.SaidaDt,
              cda_roteiro.RoteiroId,
              cda_roteiro.CarteiraId,
              cda_roteiro.FaseCartId,
              cda_roteiro.EventoId,
              cda_roteiro.ModComId,
              cda_roteiro.FilaTrabId,
              cda_roteiro.CanalId,
              cda_pessoa.*,
              cda_carteira.*,
              cda_inscrmun.*
            From
              cda_parcela
              INNER Join
              cda_pcrot On cda_parcela.PARCELAID = cda_pcrot.ParcelaId
              INNER Join
              cda_roteiro On cda_pcrot.RoteiroId = cda_roteiro.RoteiroId
              INNER Join
              cda_carteira On cda_roteiro.CarteiraId = cda_carteira.CARTEIRAID
              INNER Join
              cda_pessoa On cda_pessoa.PESSOAID = cda_parcela.PessoaId 
              LEFT Join
              cda_inscrmun On cda_parcela.PESSOAID = cda_inscrmun.PESSOAID   
              LEFT Join
              cda_regtab TRIB On cda_parcela.TRIBUTOID = TRIB.REGTABID  
       
            Where
               cda_parcela.PARCELAID in (".$this->parcelas.")";

        $parcelas= DB::select($sql." GROUP BY cda_parcela.ParcelaId");

        foreach ($parcelas as $linha){
            $tppos=PrRotCanal::where('CarteiraId',$linha->CarteiraId)
                ->where('RoteiroId',$linha->RoteiroId)
                ->orderBy('PrioridadeNr')->get();
            $pscanal=null;
            foreach ($tppos as $tp){
                $pscanal=PsCanal::where("PessoaId",$linha->PESSOAID)
                    ->where('TipPosId',$tp->TpPosId)
                    ->where('Ativo',1)
                    ->first();
                if($pscanal->PsCanalId){
                    break;
                }
            }
            if(!isset($pscanal->PsCanalId)) continue;

            if($this->Gravar){
                $sql="INSERT INTO cda_pcevento SET ";
                $sql.="PESSOAID='".$linha->PESSOAID."',";
                $sql.="INSCRMUNID='".$linha->INSCRMUNID."',";
                $sql.="PARCELAID='".$linha->PARCELAID."',";
                $sql.="EVENTOID='".$linha->EventoId."',";
                $sql.="EVENTODT='".date('Y-m-d')."',";
                $sql.="CARTEIRAID='".$linha->CarteiraId."',";
                $sql.="FILATRABID='".$linha->FilaTrabId."',";
                $sql.="PSCANALID='".$pscanal->PsCanalId."',";
                $sql.="MODCOMID='".$linha->ModComId."'";
                DB::beginTransaction();
                try {
                    DB::insert($sql);
                    DB::commit();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    DB::rollback();
                }
            }
            if($linha->ModComId>0) {

                $modelo=$linha->ModComId;

                $bairro=Bairro::find($pscanal->BairroId);
                if($bairro) $bairro= $bairro->bair_nome;

                $cidade=Cidade::find($pscanal->CidadeId);
                if($cidade) $cidade= $cidade->cida_nome.'/'.$cidade->cida_uf;

                $logradouro=Logradouro::find($pscanal->LogradouroId);
                if($logradouro) $linha->logradouro= $logradouro->logr_tipo.' '.$logradouro->logr_nome.','.$pscanal->EnderecoNr.'<br>'.$bairro.'<br>'.$cidade;

                $filas[$modelo][$linha->PESSOAID][] = $linha;
            }
        }
        $html="<style>table, th, td {border: 1px solid #D0CECE;} .page-break { page-break-after: always;}   @page { margin:5px; } html {margin:5px;} </style>";
        foreach ($filas as $modelo=> $fila){
            foreach ($fila as $pessoa){
                //$function_name="geraModelo".$modelo;
                $html.=self::geraModelo($pessoa,$modelo)."<div class='page-break'></div>";
            }
        }

        $Variaveis=RegTab::where('TABSYSID',46)->get();
        foreach ($Variaveis as $var){
            $html=str_replace("{{".$var->REGTABSG."}}","",$html);
        }
        $dir=public_path()."/filas/";
        $file="carta-".date('Ymd')."-".$this->Tarefa.".pdf";
        $html=str_replace("{{BREAK}}","<div class='page-break'></div>",$html);



        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('b4')->setWarnings(false)->loadHTML($html);
        $pdf->save($dir.$file);

        $Tarefa= Tarefas::findOrFail($this->Tarefa);
        $Tarefa->update([
            "tar_status"    => "Finalizado",
            "tar_final"    => date("Y-m-d H:i:s"),
            'tar_descricao' =>  $Tarefa->tar_descricao."<a href='".URL::to('/')."/filas/".$file."' target='_blank'>".URL::to('/')."/filas/".$file."</a>",
            "tar_jobs"      => $this->job->getJobId()
        ]);

        Artisan::call('queue:restart');
        return false;
    }

    function geraModelo($pessoa,$modeloid){

        $Modelo= ModCom::find($modeloid);

        $html=$Modelo->ModTexto;

        $ANOLANC1=$TRIB1=$VENC1=$ParcelaVr1=$JMD1=$HONOR1=$TOTAL1='';
        $PRINCT=$JMDT=$HONORT=$TOTALT=0;

        $Variaveis=RegTab::where('TABSYSID',46)->get();

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
            //foreach ($linhas as $linha) {
            //$linha=$linha[0];
            foreach ($replace as $tipo => $campo) {
                foreach ($campo as  $campos) {
                    $sg = $campos['sg'];
                    $campo = $campos['campo'];
                    switch ($tipo) {
                        case "fixo":
                            $result[$i][$sg] = $campo;
                            break;
                        case "data":
                            if (isset($linha->$campo)) {
                                $valor = Carbon::createFromFormat('Y-m-d', $linha->$campo)->format('d/m/Y');
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "numero":
                            if (isset($linha->$campo)) {
                                $valor = number_format($linha->$campo, 2, ',', '.');
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "texto":
                            if (isset($linha->$campo)) {
                                $valor = $linha->$campo;
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "array":
                            if (isset($linha->$campo)) {
                                $valor = $linha->$campo;
                                if (strpos($valor, '-') !== false) {
                                    $valor = Carbon::createFromFormat('Y-m-d', $linha->$campo)->format('d/m/Y');
                                }else{
                                    $valor =number_format($linha->$campo, 2, ',', '.');
                                }
                                $result[$i][self::soLetra($sg) . $i] = $valor;
                            }
                            break;
                        case "soma":
                            if (isset($linha->$campo)) {
                                if (isset($result[$i - 1][$sg])) {
                                    $valor = $result[$i - 1][$sg] + $linha->$campo;
                                } else {
                                    $valor = $linha->$campo;
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
}
