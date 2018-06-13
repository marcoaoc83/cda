<?php

namespace App\Http\Controllers\Admin;

use App\Models\ImpArquivo;
use App\Models\ImpLayout;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ImpLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_imp_layout = DB::table('cda_imp_layout')->get();
        return view('admin.implayout.index',compact('cda_imp_layout'));
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
");

        // show the view and pass the nerd to it
        return view('admin.implayout.create',[
            'Tabelas'=>$Tabelas
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

        ImpLayout::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('implayout.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImpLayout  $implayout
     * @return \Illuminate\Http\Response
     */
    public function show(ImpLayout $implayout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImpLayout  $implayout
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $implayout = ImpLayout::find($id);

        $Tabelas = DB::select("Select
  Replace(Upper(information_schema.tables.TABLE_NAME), 'CDA_', '') As nome,
  information_schema.tables.TABLE_NAME As alias
From
  information_schema.tables
Where
  information_schema.tables.TABLE_NAME Like 'cda_%'
");

        $Campos=DB::select("Select (INFORMATION_SCHEMA.COLUMNS.COLUMN_NAME) coluna , INFORMATION_SCHEMA.COLUMNS.TABLE_NAME tabela From INFORMATION_SCHEMA.COLUMNS 
Where
table_schema = '".DB::getDatabaseName()."'");

        $TpArq = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpArq')
            ->get();
        ;

        // show the view and pass the nerd to it
        return view('admin.implayout.edit',[
            'Campos'=>$Campos,
            'ImpLayout'=>$implayout,
            'TpArq'=>$TpArq,
            'Tabelas'=>$Tabelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImpLayout  $implayout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $implayout = ImpLayout::findOrFail($id);
        $implayout->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('implayout.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImpLayout  $implayout
     * @return \Illuminate\Http\Response
     */
    public function destroy($implayout)
    {
        $var = ImpLayout::find($implayout);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable()
    {
        $cda_imp_layout = ImpLayout::select(['cda_imp_layout.*'])
            ->get();
        ;
        return Datatables::of($cda_imp_layout)
            ->addColumn('action', function ($implayout) {

                return '
                <a href="implayout/'.$implayout->LayoutId.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteImpLayout('.$implayout->LayoutId.')" class="btn btn-xs btn-danger deleteImpLayout" >
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
and table_schema = '".DB::getDatabaseName()."'");


        return  $Campos;
    }

    public function MontaUpload(Request $request){
        $ImpArquivo = ImpArquivo::where('LayoutId', $request->LayoutId);
        dd($ImpArquivo);
    }
}
