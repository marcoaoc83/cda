<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ImportacaoJob;
use App\Models\ImpArquivo;
use App\Models\ImpCampo;
use App\Models\ImpLayout;
use App\Models\Importacao;
use App\Models\Tarefas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Softon\SweetAlert\Facades\SWAL;

class ImportacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Layout = ImpLayout::select(['cda_imp_layout.*'])->get();
        return view('admin.importacao.index',compact('Layout'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $files = (array) $request->allFiles();
        $retorno=[];
        foreach ($files as $id => $file) {
            $id=str_replace("imp_arquivo", "", $id);
            $Arquivo=ImpArquivo::find($id);
            $Campos=ImpCampo::select(['CampoNm'])->where('ArquivoId',$Arquivo->ArquivoId)->get();
            $nameFile = null;
            // Verifica se informou o arquivo e se é válido
            if ($file->isFile() && $file->isValid())
            {
                //Define um aleatório para o arquivo baseado no timestamps atual
                $name = uniqid(date('HisYmd'));
                // Recupera a extensão do arquivo
                $ext = $file->getClientOriginalExtension();
                // Define finalmente o nome
                $nameFile = "{$name}.{$ext}";
                $upload = $file->storeAs('importacao', $nameFile, 'local');
                $targetpath=storage_path("app/");
                $arquivo=($targetpath.'importacao/'.$nameFile);
                $retorno['arquivos'][$id]['file']=$nameFile;
                $retorno['arquivos'][$id]['nome']=$Arquivo->ArquivoDs;

                /* Verifica as colunas do arquivo conferem com a do layout cadastrado*/
                $fn = fopen($arquivo,"r");
                $frow = explode(';',strtolower(preg_replace("/[\n\r]/","",fgets($fn, 1000))));
                foreach ($Campos as $Campo){
                    if(!in_array(strtolower(trim($Campo->CampoNm)),$frow)){
                        $retorno['erros'][]="A coluna ".$Campo->CampoNm." não foi encontrada no arquivo ".$Arquivo->ArquivoDs."!";
                    }
                }
            }
        }

        return json_encode($retorno,JSON_UNESCAPED_UNICODE);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Importacao  $importacao
     * @return \Illuminate\Http\Response
     */
    public function show(Importacao $importacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Importacao  $importacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Importacao $importacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Importacao  $importacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Importacao $importacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Importacao  $importacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Importacao $importacao)
    {
        //
    }

    protected function importarXML($request){

        $implayout = ImpLayout::select(['cda_imp_layout.*','Campo.CampoNm','Campo.CampoDB','Campo.CampoPK','Campo.CampoValorFixo'])
            ->leftJoin('cda_imp_campo  as Campo', 'Campo.LayoutId', '=', 'cda_imp_layout.LayoutId')
            ->get();

        $xml = XmlParser::load($request->file('imp_arquivo')->getRealPath());

        foreach ($implayout as $campo){
            $arr[]="::".$campo['CampoNm'].">".$campo['CampoDB']."";
            $tabela=$campo['LayoutTabela'];
            if($campo['CampoValorFixo']){
                $campos_fixos[]=$campo['CampoDB']."='".$campo['CampoValorFixo']."'";
            }
        }

        $arr=implode(",",$arr);
        $parse = $xml->rebase('ROWDATA')->parse([
            'LINHA' => ['uses' => 'ROW[::PessoaId>PESSOAID,::RzSocialNm>PESSOANMRS]']
        ]);

        $linha=$parse["LINHA"];

        //dd($linha);
        foreach ($linha as $campos){
            $sql="INSERT INTO ".$tabela." SET " ;
            $sets=[];
            foreach ($campos as $campo => $valor){
                $sets[]=$campo."='".$valor."'";
            }
            $val=implode(" , ", $sets).' , '.implode(" , ", $campos_fixos);

            $sql.=$val." ON DUPLICATE KEY UPDATE ".$val;

            if(DB::insert($sql)){
                return true;
            }else{
                return false;
            }
        }
    }

    protected function importar(Request $request){

        $targetpath=storage_path("app/");

        $arquivos=self::split_file($targetpath."importacao/".$request->arquivo,$targetpath."importacao/split/");
        try {
            DB::beginTransaction();
            foreach ($arquivos as $arquivo) {
                self::importarCSV($request->id,$arquivo);
            }
            DB::commit();
            self::arrumaPsCanal();
            echo true;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            Log::notice($e->getMessage());
        }
    }

    private function split_file($source, $targetpath=null, $lines=1000){

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
        return $files_name;
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

                // Percorrendo a linha
                for($i=0;$i<count($data);$i++)
                {
                    $linha = $data[$i];

                    foreach ($Layout as $key => $Tabela){

                        $sql = "INSERT INTO " . $key . " SET ";
                        $values="";


                        foreach ($Tabela as $Campo) {

                            $value=$linha[$Campo["CampoNm"]];
                            if(empty($value)) $value='';
                            if($Campo["TipoDados"]=="date" || $Campo["TipoDados"]=="data"){
                                $date = Carbon::createFromFormat('d/m/Y', $value);
                                $value=$date->format('Y-m-d');
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
                        Log::info("\n\r".$sql);

                        if(empty($values)){
                            continue;
                        }
                        DB::insert($sql);
                    }
                }
                if (file_exists($path))
                unlink($path);
        }
        return true;
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

    function arrumaPsCanal(){
        $pscanal=\App\Models\PsCanal::leftJoin('cda_bairro','cda_bairro.bair_id','=','cda_pscanal.BairroId')
            ->leftJoin('cda_cidade','cda_cidade.cida_id','=','cda_pscanal.CidadeId')
            ->leftJoin('cda_logradouro','cda_logradouro.logr_id','=','cda_pscanal.LogradouroId')
            ->get();
        foreach ($pscanal as $val){

            $flight = \App\Models\PsCanal::find($val->PsCanalId);
            $flight->update([
                'Logradouro'=>$val->logr_tipo." ".$val->logr_nome,
                'Bairro'=>$val->bair_nome ,
                'Cidade'=>$val->cida_nome ,
                'UF'=>$val->cida_uf
            ]);

        }
    }
}
