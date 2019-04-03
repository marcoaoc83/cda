<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\ModeloController;
use App\Models\Bairro;
use App\Models\CanalFila;
use App\Models\Cidade;
use App\Models\ExecFila;
use App\Models\ExecFilaPsCanal;
use App\Models\ExecFilaPsCanalParcela;
use App\Models\Logradouro;
use App\Models\ModCom;
use App\Models\PcRot;
use App\Models\PortalAdm;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
    protected $Fila;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parcelas,$Tarefa,$Gravar,$Fila)
    {
        $this->parcelas=$parcelas;
        $this->Tarefa=$Tarefa;
        $this->Gravar=$Gravar;
        $this->Fila=$Fila;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filas=[];
        $Tarefa= Tarefas::findOrFail($this->Tarefa);
        $Tarefa->update([
            "tar_inicio"    => date("Y-m-d H:i:s")
        ]);

        $dir="filas/tarefa".$this->Tarefa;
        if(!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        if($this->Gravar) {
            $ExecFila = ExecFila::create([
                'exfi_fila' => $this->Fila,
                'exfi_tarefa' => $this->Tarefa,
            ]);

            $Lote = $ExecFila->exfi_lote;
        }
        $sql="Select
              cda_parcela.PARCELAID,
              cda_parcela.PESSOAID,
              cda_parcela.SITPAGID,
              cda_parcela.SITCOBID,
              cda_parcela.INSCRMUNID AS IM,
              cda_parcela.ORIGTRIBID,
              cda_parcela.LancamentoDt,
              cda_parcela.PlanoQt,
              cda_parcela.ParcelaNr,
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
              cda_roteiro.RoteiroId as idRoteiro,
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
              cda_inscrmun On cda_parcela.INSCRMUNID = cda_inscrmun.INSCRMUNID   
              LEFT Join
              cda_regtab TRIB On cda_parcela.TRIBUTOID = TRIB.REGTABID  
       
            Where
               cda_parcela.PARCELAID in (".$this->parcelas.") and FilaTrabId=$this->Fila and SaidaDt is Null and ModComId > 0";


        //Log::info($sql." GROUP BY cda_parcela.ParcelaId");
        $parcelas= DB::select($sql." GROUP BY cda_parcela.ParcelaId");
        $arrPsCanal=[];
        foreach ($parcelas as $linha){
            $tppos=PrRotCanal::where('CarteiraId',$linha->CarteiraId)
                ->where('RoteiroId',$linha->idRoteiro)
                ->orderBy('PrioridadeNr')->get();
            $pscanal=null;

            if(count($tppos)>0){
                foreach ($tppos as $tp) {
                    $pscanal = PsCanal::where("InscrMunId", $linha->IM)
                        ->where('TipPosId', $tp->TpPosId)
                        ->where('Ativo', 1)
                        ->first();
                    if ($pscanal->PsCanalId) {
                        break;
                    }
                }
            }else{
                $pscanal = PsCanal::where("InscrMunId", $linha->IM)
                    ->where('Ativo', 1)
                    ->first();
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
                $sql.="ROTEIROID='".$linha->idRoteiro."',";
                $sql.="MODCOMID='".$linha->ModComId."'";
                DB::beginTransaction();
                try {
                    DB::insert($sql);
                    if(!in_array($pscanal->PsCanalId,$arrPsCanal)) {
                        $cafi_evento=65;
                        if($this->Fila==5){
                            $cafi_evento=67;
                        }
                        CanalFila::create([
                            'cafi_fila' => $linha->FilaTrabId,
                            'cafi_fila_origem' => $linha->FilaTrabId,
                            'cafi_pscanal' => $pscanal->PsCanalId,
                            'cafi_evento' => $cafi_evento,
                            'cafi_entrada' => date("Y-m-d"),
                            'cafi_saida' => date("Y-m-d")
                        ]);
                        $arrPsCanal[]=$pscanal->PsCanalId;
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    DB::rollback();
                }
            }
            if($linha->ModComId>0) {
                $modelo=$linha->ModComId;
                $bairro=$pscanal->Bairro;
                $cidade=$pscanal->Cidade;
                $linha->logradouro= $pscanal->Logradouro.','.$pscanal->EnderecoNr.' '.$pscanal->Complemento.'<br>'.$bairro.'<br>'.$cidade;
                $linha->PsCanalId=$pscanal->PsCanalId;
                $linha->telefone=$pscanal->TelefoneNr;
                $linha->email=$pscanal->Email;
                $filas[$modelo][$linha->IM][] = $linha;
            }
        }
        $html="";
        if($this->Fila!=5) {
            $html .= "<style>table, th, td {border: 1px solid #D0CECE;} .page-break { page-break-after: always;}   @page { margin:5px; } html {margin:5px;} </style>";
        }
        foreach ($filas as $modelo=> $fila){
            foreach ($fila as $pessoa){
                $idLote=0;
                if($this->Gravar) {
                    $Notificacao = ExecFilaPsCanal::create([
                        "Lote" => $Lote,
                        "PsCanalId" => $pessoa[0]->PsCanalId,
                    ]);
                    $idLote=$Notificacao->efpa_id;
                }
                $html.=self::geraModelo($pessoa,$modelo,$Notificacao);

                if($this->Fila!=5) {
                    $html .= "<div class='page-break'></div>";
                }else{
                    $html=strip_tags($html);
                    $this->SMS($pessoa[0]->telefone,$html,$idLote );
                    $html="";
                }
                $email=$pessoa[0]->email;
            }
            if($this->Fila==4) {
                $this->EMAIL($email,$html);
                $html="";
            }
        }
        if($this->Fila==3) { //Cartas

            $Variaveis=RegTab::where('TABSYSID',46)->get();
            foreach ($Variaveis as $var){
                $html=str_replace("{{".$var->REGTABSG."}}","",$html);
            }

            $dir = public_path() . "/filas/";
            $file = "carta-" . date('Ymd') . "-" . $this->Tarefa . ".pdf";
            $html = str_replace("{{BREAK}}", "<div class='page-break'></div>", $html);
            $html = str_replace('pt;', 'px;', $html);
            $html = str_replace('0.0001px;', '0.0001pt;', $html);
            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper('b3')->setWarnings(false)->loadHTML($html);
            $pdf->save($dir . $file);
        }
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

    function geraModelo($pessoa,$modeloid,$Notificacao=null){

        $Modelo= ModCom::find($modeloid);

        $html=$Modelo->ModTexto;

        if($Notificacao) {
            $NotificacaoNR = $Notificacao->Lote . "." . $Notificacao->efpa_id;
            $NotificacaoNR = str_pad($NotificacaoNR, 10, "0", STR_PAD_LEFT);
            $ExecFila = ExecFila::find($Notificacao->Lote);
        }


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

            if(isset($linha->PARCELAID) && $this->Gravar){
                ExecFilaPsCanalParcela::create([
                    "Lote"          =>$Notificacao->Lote,
                    "Notificacao"   =>$Notificacao->efpa_id,
                    "ParcelaId"     =>$linha->PARCELAID
                ]);
            }
            //foreach ($linhas as $linha) {
            //$linha=$linha[0];
            if($Notificacao) {
                $linha->NotificacaoNR = $NotificacaoNR;
                $linha->NotificacaoData = $ExecFila->exfi_data;
            }else{
                $linha->NotificacaoNR = "00000000000";
                $linha->NotificacaoData = date("d/m/Y");
            }
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
                        case "textoFirst":
                            if (isset($linha->$campo)) {
                                $valor = explode(' ',$linha->$campo);
                                $result[$i][$sg] = trim($valor[0]);
                            }
                            break;
                        case "array":
                            if (isset($linha->$campo)) {
                                $valor = $linha->$campo;
                                if (strpos($valor, '-') !== false) {
                                    $valor = Carbon::createFromFormat('Y-m-d', $linha->$campo)->format('d/m/Y');
                                }
                                $result[$i][self::soLetra($sg) . $i] = $valor;
                            }
                            break;
                        case "arrayNumber":
                            if (isset($linha->$campo)) {
                                $valor = $linha->$campo;
                                if(is_numeric($valor))
                                    $valor =number_format($valor, 2, ',', '.');
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

    private function SMS($numero,$msg,$lote){
        $msg=html_entity_decode($msg);

        $url="http://54.233.99.254/webservice-rest/send-single?user=marcoaoc83&password=300572&country_code=55&number=$numero&content=$msg&campaign_id=$lote&type=0";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $url2="http://54.233.99.254/webservice-rest/send-single?user=marcoaoc83&password=300572&country_code=55&number=$numero&content=$msg&campaign_id=$lote&type=5";
        $client2 = new \GuzzleHttp\Client();
        $response2 = $client->request('GET', $url2);
        return true;
    }
    private function EMAIL($email,$msg){
        $cda_portal = PortalAdm::get();
        $cda_portal=$cda_portal[0];

        Mail::to($email)->send(new \App\Mail\SendMailFilas($cda_portal->port_titulo,$msg));
        return true;
    }
}
