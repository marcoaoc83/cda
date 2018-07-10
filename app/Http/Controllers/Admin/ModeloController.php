<?php

namespace App\Http\Controllers\Admin;

use App\Models\ModCom;
use App\Models\RegTab;
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

class ModeloController extends Controller
{
    public function index()
    {
        $cda_modcom = DB::table('cda_modcom')->get();

        return view('admin.modelo.index',compact('cda_modcom'));
    }

    public function getPosts()
    {
        $cda_modcom = ModCom::select(['ModComID', 'ModComSG', 'ModComNM','CANALNM'])
            ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_modcom.CanalId');

        return Datatables::of($cda_modcom)
            ->addColumn('action', function ($modelo) {

                return '
                <a href="modelo/editar/'.$modelo->ModComID.'" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteModCom('.$modelo->ModComID.')" class="btn btn-xs btn-danger deleteModCom" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function getEditar($id)
    {
        // get the nerd
        $modelo = ModCom::find($id);
        $cda_modcom = DB::table('cda_modcom')->get();
        $tipoModelo = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpMod')
            ->get();

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

        $canais = DB::table('cda_canal')->get();
        // show the view and pass the nerd to it
        return View::make('admin.modelo.form')
            ->with('modelo', $modelo)
            ->with('cda_modcom', $cda_modcom)
            ->with('tipoModelo', $tipoModelo)
            ->with('Tabelas', $Tabelas)
            ->with('Campos', $Campos)
            ->with('canais', $canais);
    }

    public function postEditar(Request $request, $id)
    {


        $modelo = ModCom::findOrFail($id);
        $modelo->ModComSg       = $request->ModComSg;
        $modelo->ModComNm       = $request->ModComNm;
        $modelo->TpModId       = $request->TpModId;
        $modelo->CanalId       = $request->CanalId;
        $modelo->ModComAnxId       = $request->ModComAnxId;
        $modelo->ModTexto       = $request->ModTexto;
        $modelo->save();
        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('admin.modelo');

    }

    public function getInserir()
    {
        $cda_modcom = DB::table('cda_modcom')->get();
        $tipoModelo = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpMod')
            ->get();
        ;
        $canais = DB::table('cda_canal')->get();
        // show the view and pass the nerd to it
        return view('admin.modelo.insere',[
            'cda_modcom'=>$cda_modcom,
            'tipoModelo'=>$tipoModelo,
            'canais'=>$canais
        ]);
    }


    public function postInserir(Request $request)
    {
        $data = $request->all();

        ModCom::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('admin.modelo');
    }

    public function postDeletar($id)
    {
        $modelo = ModCom::find($id);
        if($modelo->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }
}
