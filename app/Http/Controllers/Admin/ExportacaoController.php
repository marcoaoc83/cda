<?php

namespace App\Http\Controllers\Admin;

 
use App\Models\ExpArquivo;
use App\Models\ExpCampo;
use App\Models\ExpCampoPrincipal;
use App\Models\ExpLayout;
use App\Models\Fila;
use App\Models\ImpArquivo;
use App\Models\ImpCampo;
use App\Models\ImpLayout;
use App\Models\Exportacao;

use App\Models\Relatorios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Softon\SweetAlert\Facades\SWAL;

class ExportacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Layout = ExpLayout::all();
        $FilaTrab=Fila::all();
        return view('admin.exportacao.index',compact('Layout','FilaTrab'));
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
                $upload = $file->storeAs('exportacao', $nameFile, 'local');
                $targetpath=storage_path("app/");
                $arquivo=($targetpath.'exportacao/'.$nameFile);
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
     * @param  \App\Models\Exportacao  $exportacao
     * @return \Illuminate\Http\Response
     */
    public function show(Exportacao $exportacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exportacao  $exportacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Exportacao $exportacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exportacao  $exportacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exportacao $exportacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exportacao  $exportacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exportacao $exportacao)
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

        $arquivos=self::split_file($targetpath."exportacao/".$request->arquivo,$targetpath."exportacao/split/");
        try {
            DB::beginTransaction();
            foreach ($arquivos as $arquivo) {
                self::importarCSV($request->id,$arquivo);
            }
            DB::commit();
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
                            if(empty($value)) continue;
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
                        //Log::info("\n\r".$sql);

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

    public function montaFiltro(Request $request)
    {
        $fila = Relatorios::where('rel_id',$request->rel_id)->first()->toArray();

        return response()->json($fila);
    }

    public function exportar(Request $request)
    {

        $tabela=ExpLayout::find($request->exp_id);
        $campos=ExpCampoPrincipal::where('epc_layout_id',$request->exp_id)->orderBy('epc_ord')->get();
        foreach ($campos as $campo){
            $header[]=$campo->epc_titulo;
            $set[]=$campo->epc_campo;
        }
        $sql="select ".implode(',',$set)." from ".$tabela->exp_tabela;
        if($request->demo){
            $sql.=" limit 5";
        }
        $collect=DB::select($sql);
        $dados[]=$header;
        $x=1;
        foreach ($collect as $linha){
            $i=0;
            foreach ($linha as $info){
                $dados[$x][$i]=$info;
                $i++;
            }
            $x++;
        }
        $type='csv';
        if($request->demo) $type='html';
        $targetpath=storage_path("../public/export");
        $file=md5(uniqid(rand(), true));
        $csv= Excel::create($file, function($excel) use ($dados) {
            $excel->sheet('mySheet', function($sheet) use ($dados)
            {
                $sheet->fromArray($dados,null,'A1', false, false);
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

            $ret="<h6><a href='" . URL::to('/') . "/export/" . $file . ".csv' target='_blank'>Arquivo Principal</a></h6>";
            $arqSec=ExpArquivo::where('ext_layout_id',$request->exp_id)->get();
            foreach ($arqSec as $arquivo){
                unset($dados);
                unset($header);
                $resCampos=ExpCampo::where('exc_tabela',$arquivo->ext_id)->get();
                foreach ($resCampos as $campo){
                    $colunas[]=$arquivo->ext_tabela.".".$campo->exc_campo." as '".$campo->exc_titulo."'";
                    $group[]=$arquivo->ext_tabela.".".$campo->exc_campo;
                    $header[]=$campo->exc_titulo;
                }
                $sql="SELECT ".implode(',',$colunas)." from ".$arquivo->ext_tabela;
                $sql.=" INNER JOIN ".$tabela->exp_tabela." ON ".$arquivo->ext_tabela.".".$arquivo->ext_campo."=".$tabela->exp_tabela.".".$arquivo->ext_campo_fk;
                $sql.=" group by ".implode(',',$group);
                $collect=DB::select($sql);

                $dados[]=$header;
                $x=1;
                foreach ($collect as $linha){
                    $i=0;
                    foreach ($linha as $info){
                        $dados[$x][$i]=$info;
                        $i++;
                    }
                    $x++;
                }
                $type='csv';

                $targetpath=storage_path("../public/export");
                $file=md5(uniqid(rand(), true));
                $csv= Excel::create($file, function($excel) use ($dados) {
                    $excel->sheet('mySheet', function($sheet) use ($dados)
                    {
                        $sheet->fromArray($dados,null,'A1', false, false);
                    });
                })->store($type,$targetpath);
                $ret.="<h6><a href='" . URL::to('/') . "/export/" . $file . ".csv' target='_blank'>Arquivo - ".$arquivo->ext_nome."</a></h6>";
            }

            return response()->json($ret);
        }



    }
}
