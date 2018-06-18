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

        $ImpCampo = ImpCampo::select(['*'])
            ->where('ArquivoId',  $request->ArquivoId)
            ->get();

        foreach ($ImpCampo as $campos){
            $Layout[$campos['TabelaDB']]=$campos;
        }

        dd($ImpCampo[0]['CampoNm']);

        $path = $request->file('imp_arquivo')->getRealPath();
        $data = Excel::load($path)->get();
        if(!empty($data) && $data->count())
        {
            $data = $data->toArray();
            // Percorrendo a linha
            for($i=0;$i<count($data);$i++)
            {
                $linha = $data[$i];

            }
        }


    }
}
