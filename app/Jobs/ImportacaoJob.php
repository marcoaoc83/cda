<?php

namespace App\Jobs;

use App\Models\ImpCampo;
use App\Models\Importacao;
use App\Models\Tarefas;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ArquivoId;
    protected $File;
    protected $Tarefa;
    protected $SpliceFile=[];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ArquivoId,$File,$Tarefa)
    {
       $this->ArquivoId=$ArquivoId;
       $this->File=$File;
       $this->Tarefa=$Tarefa;
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
            "tar_status" => "Em Execução"
        ]);
        $targetpath=storage_path("app/");

        $arquivos=self::split_file($targetpath.$this->File,$targetpath."importacao/split/");

        foreach ($arquivos as $arquivo) {
            ImportacaoSplitJob::dispatch($this->ArquivoId,$arquivo,$this->Tarefa,count($arquivos))->onQueue("importacao");
        }

    }

    function split_file($source, $targetpath=null, $lines=1000){

        $i=0;
        $j=1;
        $date =date("YmdHis");
        $buffer='';

        $handle = fopen ($source, "r");
        $files_name=[];
        while (!feof ($handle)) {

            $row = fgets($handle, 4096);

            if (empty($header)){
                $header = $row;
                continue;
            }
            if($i<=$lines){
                $fname =$targetpath."part_".$date."--".$j.".csv";
                if(!in_array($fname,$files_name)){
                    $files_name[]=$fname;
                }
                if(empty($fhandle)) {
                    $fhandle = fopen($fname, "w") or die($php_errormsg);
                    fwrite($fhandle,$header.$row);
                }else{
                    fwrite($fhandle,$row);
                }
                $i++;
            }else{
                fwrite($fhandle,$row);
                fclose($fhandle);

                $fhandle=null;
                $i=0;
                $j++;
            }
        }
        fclose ($handle);
       // Artisan::call('queue:restart');
        return $files_name;
    }

}
