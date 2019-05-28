<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ImportacaoJob;
use App\Models\ImpArquivo;
use App\Models\ImpCampo;
use App\Models\ImpLayout;
use App\Models\Importacao;
use App\Models\Tarefas;
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
                $retorno['arquivos'][$id]=$nameFile;

                /* Verifica as colunas do arquivo conferem com a do layout cadastrado*/
                $fn = fopen($arquivo,"r");
                $frow = explode(';',strtolower(preg_replace("/[\n\r]/","",fgets($fn, 20))));
                foreach ($Campos as $Campo){
                    if(!in_array(strtolower($Campo->CampoNm),$frow)){
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

}
