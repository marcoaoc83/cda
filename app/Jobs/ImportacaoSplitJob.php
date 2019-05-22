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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportacaoSplitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ArquivoId;
    protected $File;
    protected $Tarefa;
    protected $TotalArquivos;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ArquivoId,$File,$Tarefa,$TotalArquivos)
    {
        $this->ArquivoId=$ArquivoId;
        $this->File=$File;
        $this->Tarefa=$Tarefa;
        $this->TotalArquivos=$TotalArquivos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        self::importarCSV($this->ArquivoId, $this->File);
        $qt=explode("--",$this->File);
        $qt=explode(".",$qt[1]);
        if($qt[0]==$this->TotalArquivos){
            $Tarefa= Tarefas::findOrFail($this->Tarefa);
            $Tarefa->update([
                "tar_status"    => "Finalizado",
                "tar_jobs"      => $this->job->getJobId()
            ]);
        }
    }

    public function importarCSV($ArquivoId,$path){

        $ImpCampo = ImpCampo::where('ArquivoId', $ArquivoId)->orderBy("OrdTable","asc")->get()->toArray();
        foreach ($ImpCampo as $campos){
            $Layout[$campos['TabelaDB']][] = json_decode(json_encode($campos), true);
        }

        $data = self::csv_to_array($path,";");

        $coluna_fk=[];
        $consulta_fk=[];

        if(!empty($data) )
        {

            try {
                // Percorrendo a linha
                for($i=0;$i<count($data);$i++)
                {
                    $linha = $data[$i];

                    foreach ($Layout as $key => $Tabela){

                        $sql = "INSERT INTO " . $key . " SET ";
                        $values="";


                        foreach ($Tabela as $Campo) {

                            $value=$linha[$Campo["CampoNm"]];
                            if(empty($value)) continue;
                            if($Campo["TipoDados"]=="date" || $Campo["TipoDados"]=="data"){
                                $value=strftime("%Y-%m-%d", strtotime($value));
                            }
                            if($Campo["TipoDados"]=="int"){
                                $value=preg_replace("/[^0-9]/", "", $value);
                            }
                            if($Campo["TipoDados"]=="moedabr"){
                                $value=str_replace([".","$","R"],"",$value);
                                $value=trim(str_replace(",",".",$value));
                            }

                            if($Campo["CampoTipo"]==1) {
                                $values .= $Campo["CampoDB"]." = '".$value."',";
                            }

                            if($Campo["CampoTipo"]==2) {
                                $values .= $Campo["CampoDB"]." = '".$Campo["CampoValorFixo"]."',";
                            }

                            if($Campo["CampoTipo"]==3) {
                                $var=null;
                                if(empty($coluna_fk[$Campo['FKTabela']])) {
                                    $query = "SELECT column_name AS coluna FROM information_schema.columns WHERE table_schema=DATABASE() AND  column_key='PRI' AND table_name='" . $Campo['FKTabela'] . "'";
                                    $coluna = DB::select($query);
                                    $coluna=$coluna[0]->coluna;
                                    $coluna_fk[$Campo['FKTabela']]=$coluna;
                                }else{
                                    $coluna=$coluna_fk[$Campo['FKTabela']];
                                }

                                if(empty($consulta_fk[$Campo['FKTabela']][$Campo['FKCampo']][$value])){
                                    $query=" SELECT * FROM ".$Campo['FKTabela']." WHERE ".$Campo['FKCampo']." = '".$value."'";
                                    $fk=DB::select($query);
                                    if($fk[0]) {
                                        $var = $fk[0]->{$coluna};
                                        $consulta_fk[$Campo['FKTabela']][$Campo['FKCampo']][$value] = $var;
                                    }

                                }else{
                                    $var=$consulta_fk[$Campo['FKTabela']][$Campo['FKCampo']][$value];
                                }

                                $values .= " " . $Campo["CampoDB"] . " = '" . $var . "',";

                            }
                        }

                        $values=substr_replace($values, '', -1);
                        $sql=$sql.$values;
                        $sql.=" ON DUPLICATE KEY UPDATE ".$values;
                        //Log::info("\n\r".$sql);
                        DB::beginTransaction();
                        DB::insert($sql);
                        DB::commit();
                    }
                }

                unlink($path);
            } catch (\Exception $e) {
                echo $e->getMessage();
                DB::rollback();
            }
        }
        echo "Arquivo Importado. \n\n";
    }

    public function csv_to_array($filename = '') {
        $row = 0;
        $col = 0;

        $handle = @fopen($filename, "r");
        if ($handle)
        {
            while (($row = fgetcsv($handle, 4096,';')) !== false)
            {
                if (empty($fields))
                {
                    $fields = $row;
                    continue;
                }

                foreach ($row as $k=>$value)
                {
                    $results[$col][$fields[$k]] = $value;
                }
                $col++;
                unset($row);
            }
            if (!feof($handle))
            {
                echo "Error: unexpected fgets() failn";
            }
            fclose($handle);
        }

        return $results;
    }
    function csv_to_array2($filename='', $delimiter=';')
    {
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 4000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}
