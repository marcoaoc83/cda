<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpArquivo;
use App\Models\ExpLayout;
use App\Models\RegTab;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExpLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_exp_layout = ExpLayout::get();
        return view('admin.explayout.index',compact('cda_exp_layout'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Tabelas = DB::select("Select
  Replace(Upper(information_schema.tables.TABLE_NAME), 'CDA_', '') As nome,
  information_schema.tables.TABLE_NAME As alias
From
  information_schema.tables
Where
  information_schema.tables.TABLE_NAME Like 'cda_%'
  	group by nome");

        $Extensoes= RegTab::where('TABSYSID',9)->get();
        // show the view and pass the nerd to it
        return view('admin.explayout.create',[
            'Tabelas'=>$Tabelas,
            'Extensoes'=>$Extensoes
        ]);

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

        ExpLayout::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('explayout.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpLayout  $explayout
     * @return \Illuminate\Http\Response
     */
    public function show(ExpLayout $explayout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpLayout  $explayout
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $explayout = ExpLayout::find($id);

        $Tabelas = DB::select("Select
  Replace(Upper(information_schema.tables.TABLE_NAME), 'CDA_', '') As nome,
  information_schema.tables.TABLE_NAME As alias
From
  information_schema.tables
Where
  information_schema.tables.TABLE_NAME Like 'cda_%'
  	group by nome
");

        $Campos=DB::select("Select (INFORMATION_SCHEMA.COLUMNS.COLUMN_NAME) coluna , INFORMATION_SCHEMA.COLUMNS.TABLE_NAME tabela From INFORMATION_SCHEMA.COLUMNS 
Where
table_schema = '".DB::getDatabaseName()."'");

        $TpArq = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpArq')
            ->get();
        ;
        $Extensoes= RegTab::where('TABSYSID',9)->get();
        // show the view and pass the nerd to it
        return view('admin.explayout.edit',[
            'Campos'=>$Campos,
            'ExpLayout'=>$explayout,
            'TpArq'=>$TpArq,
            'Extensoes'=>$Extensoes,
            'Tabelas'=>$Tabelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpLayout  $explayout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $explayout = ExpLayout::findOrFail($id);
        $explayout->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('explayout.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpLayout  $explayout
     * @return \Illuminate\Http\Response
     */
    public function destroy($explayout)
    {
        $var = ExpLayout::find($explayout);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable()
    {
        $cda_exp_layout = ExpLayout::get();
    
        return Datatables::of($cda_exp_layout)
            ->addColumn('action', function ($explayout) {

                return '
                <a href="explayout/'.$explayout->exp_id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteExpLayout('.$explayout->exp_id.')" class="btn btn-xs btn-danger deleteExpLayout" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function getCampos(Request $request)
    {
        $Campos=DB::select("Select 
(INFORMATION_SCHEMA.COLUMNS.COLUMN_NAME) coluna , 
INFORMATION_SCHEMA.COLUMNS.TABLE_NAME tabela 
From INFORMATION_SCHEMA.COLUMNS 
Where
INFORMATION_SCHEMA.COLUMNS.TABLE_NAME= '{$request->tabela}'
and table_schema = '".DB::getDatabaseName()."' 	group by coluna");


        return  $Campos;
    }

    public function montaArquivo(Request $request){
        $ExpArquivo = ExpArquivo::where('exp_id', $request->exp_id)->orderBy('ArquivoOrd','asc');
        return json_encode($ExpArquivo->get()->all(),JSON_UNESCAPED_UNICODE);
    }
}
