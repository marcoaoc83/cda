<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\ModeloController;
use App\Models\ModCom;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parcelas,$Tarefa)
    {
        $this->parcelas=$parcelas;
        $this->Tarefa=$Tarefa;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

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

            $sql="INSERT INTO cda_pcevento SET ";
            $sql.="PESSOAID='".$linha->PESSOAID."',";
            $sql.="INSCRMUNID='".$linha->INSCRMUNID."',";
            $sql.="PARCELAID='".$linha->PARCELAID."',";
            $sql.="EVENTOID='".$linha->EventoId."',";
            $sql.="EVENTODT='".date('Y-m-d')."',";
            $sql.="CARTEIRAID='".$linha->CarteiraId."',";
            $sql.="FILATRABID='".$linha->FilaTrabId."',";
            $sql.="PSCANALID='".$linha->CanalId."',";
            $sql.="MODCOMID='".$linha->ModComId."'";
            DB::beginTransaction();
            try {
                DB::insert($sql);
                DB::commit();
            } catch (\Exception $e) {
                echo $e->getMessage();
                DB::rollback();
            }
            if($linha->ModComId>0) {
                $pessoas[$linha->PESSOAID][] = $linha;
                $modelo=$linha->ModComId;
            }
        }
        $html="<style>table, th, td {border: 1px solid #D0CECE;} .page-break { page-break-after: always;}   @page { margin:5px; } html {margin:5px;} </style>";
        foreach ($pessoas as $pessoa){
            $function_name="geraModelo".$modelo;
            $html.=self::$function_name($pessoa,$modelo)."<div class='page-break'></div>";
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
            'tar_descricao' =>  "<a href='".URL::to('/')."/filas/".$file."' target='_blank'>LINK DO ARQUIVO</a>",
            "tar_jobs"      => $this->job->getJobId()
        ]);

        Artisan::call('queue:restart');
        return false;
    }

    function geraModelo2($pessoa){

        $Modelo= ModCom::with("Variaveis")->find(2);
        //error_log(print_r($Modelo->Variaveis(),1));
        $html=$Modelo->ModTexto;
        $ANOLANC1=$TRIB1=$VENC1=$ParcelaVr1=$JMD1=$HONOR1=$TOTAL1='';
        $PRINCT=$JMDT=$HONORT=$TOTALT=0;
        foreach ($pessoa as $linha){

            $html= str_replace("{{ParcelamentoNm}}",$linha->CARTEIRANM,$html);
            //$html= str_replace("{{ParcelamentoNr}}",$linha->CARTEIRANM,$html);
            $html=str_replace("{{IncricaoNr}}",$linha->INSCRMUNNR." - ".$linha->CPF_CNPJNR,$html);
            $html=str_replace("{{ContribuinteNr}}",$linha->PESSOANMRS,$html);
            if(!empty($linha->LancamentoDt))
                $ANOLANC1.=Carbon::createFromFormat('Y-m-d', $linha->LancamentoDt)->format('d/m/Y')."<br>";
            $TRIB1.=$linha->TRIBUTONM."<br>";
            if(!empty($linha->VencimentoDt))
                $VENC1.=Carbon::createFromFormat('Y-m-d', $linha->VencimentoDt)->format('d/m/Y')."<br>";
            $ParcelaVr1.=$linha->PrincipalVr."<br>";
            $PRINCT+=$linha->PrincipalVr;
            $JMD1.=$linha->JurosVr."<br>";
            $JMDT+=$linha->JurosVr;
            $HONOR1.=$linha->MultaVr."<br>";
            $HONORT+=$linha->MultaVr;
            $TOTAL1.=$linha->TotalVr."<br>";
            $TOTALT+=$linha->TotalVr;
        }
        //error_log(print_r($Modelo->Variaveis,1));
        foreach ($Modelo->Variaveis as $var) {
            $html=str_replace($var->var_codigo,$var->var_valor,$html);
        }

        $html=str_replace("{{VectoDt1}}",$VENC1,$html);
        $html=str_replace("{{ParcelaVr1}}",$ParcelaVr1,$html);
        $html=str_replace("{{Atualvr1}}",$ParcelaVr1,$html);
        $html=str_replace("{{Jurosvr1}}",$JMD1,$html);
        $html=str_replace("{{Multavr1}}",$HONOR1,$html);
        $html=str_replace("{{TotalVr1}}",$TOTAL1,$html);
        $html=str_replace("{{TOTALT}}",$TOTALT,$html);

        $html=str_replace("{{NotificacaoNr}}",date('Y').str_pad($this->Tarefa,8,"0",STR_PAD_LEFT),$html);
        $html=str_replace("{{NotificacaoDt}}",Carbon::parse()->format('d/m/Y'),$html);

        return $html;


    }
}
