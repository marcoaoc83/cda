<?php

namespace App\Jobs;

use App\Models\Tarefas;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;

class ExecFilaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $Dados;
    protected $Tarefa;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($Dados,$Tarefa)
    {
       $this->Dados=$Dados;
       $this->Tarefa=$Tarefa;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $where = "";

        if(!empty($this->Dados['FilaTrabId'])){
            $where.=' AND cda_roteiro.FilaTrabId='.$this->Dados['FilaTrabId'];
        }

        if(!empty($this->Dados['roteirosId'])){
            $where.=' AND cda_roteiro.RoteiroId IN ('.implode(',',$this->Dados['roteirosId']).')';
        }


        $sql="Select
              cda_parcela.PARCELAID,
              cda_parcela.PESSOAID,
              cda_parcela.SITPAGID,
              cda_parcela.SITCOBID,
              cda_parcela.INSCRMUNID,
              cda_parcela.ORIGTRIBID,
              cda_parcela.TRIBUTOID,
              cda_pcrot.SaidaDt,
              cda_roteiro.RoteiroId,
              cda_roteiro.CarteiraId,
              cda_roteiro.FaseCartId,
              cda_roteiro.EventoId,
              cda_roteiro.ModComId,
              cda_roteiro.FilaTrabId,
              cda_roteiro.CanalId
            From
              cda_parcela
              INNER Join
              cda_pcrot On cda_parcela.PARCELAID = cda_pcrot.ParcelaId
              INNER Join
              cda_roteiro On cda_pcrot.RoteiroId = cda_roteiro.RoteiroId
              INNER Join
              cda_pessoa On cda_pessoa.PessoaId = cda_parcela.PessoaId   
            Where
              (cda_pcrot.SaidaDt Is Null) ".$where;

        $parcelas= DB::select($sql);

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
        }

        $Tarefa= Tarefas::findOrFail($this->Tarefa);
        $Tarefa->update([
            "tar_status"    => "Finalizado",
            "tar_jobs"      => $this->job->getJobId()
        ]);

        echo true;
    }
}
