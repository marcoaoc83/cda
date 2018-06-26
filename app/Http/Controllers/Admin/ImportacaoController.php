<?php

namespace App\Http\Controllers\Admin;

use App\Models\ImpCampo;
use App\Models\ImpLayout;
use App\Models\Importacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        // Verifica se informou o arquivo e se é válido
        if ($request->hasFile('imp_arquivo') && $request->imp_arquivo->isValid()) {
            $ext = $request->imp_arquivo->getClientOriginalExtension();
            if($ext == "xml"){
                if($this->importarXML($request)){
                    SWAL::message('Salvo','Importação realizada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
                }else{
                    SWAL::message('Erro','Falha ao importar','error',['timer'=>4000,'showConfirmButton'=>false]);
                }

            }elseif($ext == "csv"){
                if($this->importarCSV($request)){
                    SWAL::message('Salvo','Importação realizada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
                }else{
                    SWAL::message('Erro','Falha ao importar','error',['timer'=>4000,'showConfirmButton'=>false]);
                }

            }

            // redirect
            return redirect()->route('importacao.index');
        }

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

    protected function importarCSV($request){
        //DB::disableQueryLog();
        ini_set("max_input_time",-1);
        ini_set('memory_limit', -1);
        $ImpCampo = ImpCampo::select(['*'])
            ->where('ArquivoId',  $request->ArquivoId)
            ->orderBy("OrdTable","asc")
            ->get()->all();

        foreach ($ImpCampo as $campos){
            $Layout[$campos['TabelaDB']][] = json_decode(json_encode($campos), true);
        }

        $path = $request->file('imp_arquivo')->getRealPath();
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
                        $value=$linha[($Campo["CampoNm"])];

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

        // redirect
        SWAL::message('Salvo','Importado com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect("admin/importacao");
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
