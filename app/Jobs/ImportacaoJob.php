<?php

namespace App\Jobs;

use App\Models\ImpCampo;
use App\Models\Importacao;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ImportacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ArquivoId;
    protected $File;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ArquivoId,$File)
    {
       $this->ArquivoId=$ArquivoId;
       $this->File=$File;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        self::importarCSV($this->ArquivoId,$this->File);

    }

    public function importarCSV($ArquivoId,$upload){

        $ImpCampo = ImpCampo::select(['*'])
            ->where('ArquivoId', $ArquivoId)
            ->orderBy("OrdTable","asc")
            ->get()->all();

        foreach ($ImpCampo as $campos){
            $Layout[$campos['TabelaDB']][] = json_decode(json_encode($campos), true);
        }

        $path = storage_path("app/".$upload);
        $data = self::csv_to_array($path,";");

        $coluna_fk=[];
        $consulta_fk=[];

        if(!empty($data) )
        {
            // Percorrendo a linha
            for($i=0;$i<count($data);$i++)
            {
                $linha = $data[$i];

                foreach ($Layout as $key => $Tabela){

                    $sql = "INSERT INTO " . $key . " SET ";
                    $values="";


                    foreach ($Tabela as $Campo) {

                        $value=$linha[$Campo["CampoNm"]];

                        if($Campo["TipoDados"]=="date"){
                            $value=strftime("%Y-%m-%d", strtotime($value));
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
                    $sql=$sql.$values." ON DUPLICATE KEY UPDATE ".$values;

                    DB::insert($sql);

                }
            }
        }

        echo "ok";
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
}