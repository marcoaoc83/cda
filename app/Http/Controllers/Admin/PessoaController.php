<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bairro;
use App\Models\Canal;
use App\Models\CanalFila;
use App\Models\Cidade;
use App\Models\Help;
use App\Models\InscrMun;
use App\Models\Logradouro;
use App\Models\Parcela;
use App\Models\PcRot;
use App\Models\Pessoa;
use App\Models\PsCanal;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_pessoa = DB::table('cda_pessoa')->get();
        $Route=Route::current()->getName();
        $Help= Help::where('help_formulario',$Route)->get();
        $help_titulo=$Help[0]->help_titulo;
        $help_texto=$Help[0]->help_texto;

        return view('admin.pessoa.index',compact('cda_pessoa','help_titulo','help_texto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // show the view and pass the nerd to it
        return view('admin.pessoa.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['CPF_CNPJNR']=preg_replace('/[^0-9]/','',$data['CPF_CNPJNR']);
        Pessoa::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('pessoa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function show(Pessoa $pessoa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $pessoa = Pessoa::find($id);

        $ORIGTRIB = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','OrigTrib')
            ->get();

        $FonteInfoId = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','FonteInfo')
            ->get();

        $Canal = DB::table('cda_canal')->get();

        $PessoaIdSR = DB::table('cda_pessoa')->get();
        $PessoaIdCP = DB::table('cda_pessoa')->get();

        $TipPos = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpPos')
            ->get();

        $StPag = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','StPag')
            ->get();

        $SitCob = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','StCob')
            ->get();

        $Tributo = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','Tributo')
            ->get();

        // show the view and pass the nerd to it
        return view('admin.pessoa.edit',[
            'Pessoa'=>$pessoa,
            'FonteInfoId'=>$FonteInfoId,
            'Canal'=>$Canal,
            'TipPos'=>$TipPos,
            'PessoaIdSR'=>$PessoaIdSR,
            'PessoaIdCP'=>$PessoaIdCP,
            'ORIGTRIB'=>$ORIGTRIB,
            'SitCob'=>$SitCob,
            'Tributo'=>$Tributo,
            'StPag'=>$StPag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request['CPF_CNPJNR']=preg_replace('/[^0-9]/','',$request['CPF_CNPJNR']);
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('pessoa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function destroy($pessoa, Request $r)
    {
        if($r->all){
            Parcela::truncate();
            PsCanal::truncate();
            InscrMun::truncate();
            Pessoa::truncate();
            Logradouro::truncate();
            Bairro::truncate();
            Cidade::truncate();
            PcRot::truncate();
            CanalFila::truncate();
            return 'true';
        }
        $var = Pessoa::find($pessoa);
        if($var->delete()) {
            return 'true';
        }else{
            return false;
        }
    }

    public function getDadosDataTable()
    {
        $cda_pessoa = Pessoa::select(['PESSOAID','PESSOANMRS', 'CPF_CNPJNR']);

        return Datatables::of($cda_pessoa)
            ->addColumn('action', function ($pessoa) {

                return '
                <a href="pessoa/'.$pessoa->PESSOAID.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deletePessoa('.$pessoa->PESSOAID.')" class="btn btn-xs btn-danger deletePessoa" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function findPessoa()
    {
        $data = strtolower(Input::get('query'));
        $cda_pessoa = Pessoa::select(['PESSOAID','PESSOANMRS', 'CPF_CNPJNR'])
            ->whereRaw('
            CPF_CNPJNR <> "" and 
            (LOWER(PESSOANMRS) LIKE "%'.trim(strtolower($data)).'%" or CPF_CNPJNR LIKE "%'.trim(strtolower($data)).'%" ) ');
        //dd($cda_pessoa);
        // error_log($cda_pessoa->toSql());
        $pessoas=$cda_pessoa->get()->all();
        $x=0;
        $return=[];
        foreach ($pessoas as $pessoa){
            $return[$x]['id']= $pessoa['PESSOAID'];
            $return[$x]['name']= strtoupper($pessoa['PESSOANMRS'])." - ".$pessoa['CPF_CNPJNR'];
            $x++;
        }
        return json_encode($return,JSON_UNESCAPED_UNICODE);
    }
    public function export(Request $request)
    {
        if($request->tipo == "csv"){
            return self::exportCSV();
        }
        if($request->tipo == "txt"){
            return self::exportTXT();
        }
        if($request->tipo == "pdf"){
            return self::exportPDF();
        }
    }

    public function exportPDF()
    {
        ini_set('max_execution_time', 500);
        $data = Pessoa::select('PESSOAID as ID','CPF_CNPJNR as DOCUMENTO' ,'PESSOANMRS as NOME')->limit(1000)->get();
        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('admin.pessoa.export',  compact('data'));
        // If you want to store the generated pdf to the server then you can use the store function
        //$pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function
        //$pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('pessoa.pdf');
    }

    public function exportCSV()
    {
        $data = Pessoa::select('PESSOAID as ID','CPF_CNPJNR as DOCUMENTO' ,'PESSOANMRS as NOME')->get()->toArray();
        return Excel::create('pessoa', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download("csv");
    }

    public function exportTXT()
    {
        $data = Pessoa::select('PESSOAID as ID','CPF_CNPJNR as DOCUMENTO' ,'PESSOANMRS as NOME')->get()->toArray();
        return Excel::create('pessoa', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download("txt");
    }

    public function getDadosDataTableIM()
    {
        $cda_pessoa = Pessoa::select(['cda_pessoa.PESSOAID','PESSOANMRS','CPF_CNPJNR','INSCRMUNNR'])->leftJoin("cda_inscrmun","cda_inscrmun.PESSOAID","=","cda_pessoa.PESSOAID");

        return Datatables::of($cda_pessoa)->make(true);
    }

    public function getDadosDataTableCanal(Request $request)
    {
        $Canal=Canal::where('CANALID',$request->canal)->first()->toArray();

        return response()->json($Canal);
    }
}
