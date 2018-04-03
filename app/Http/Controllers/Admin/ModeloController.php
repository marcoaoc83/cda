<?php

namespace App\Http\Controllers\Admin;

use App\Models\ModCom;
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
        $cda_modcom = ModCom::select(['ModComID', 'ModComSG', 'ModComNM']);

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

        // show the view and pass the nerd to it
        return View::make('admin.modelo.form')
            ->with('modelo', $modelo);
    }

    public function postEditar(Request $request, $id)
    {


        $modelo = ModCom::findOrFail($id);
        $modelo->ModComSG       = $request->ModComSG;
        $modelo->ModComNM       = $request->ModComNM;
        $modelo->save();
        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('admin.modelo');

    }

    public function getInserir()
    {

        // show the view and pass the nerd to it
        return view('admin.modelo.insere',compact('cda_modcom'));
    }


    public function postInserir(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'ModComSG'       => 'required',
            'ModComNM'      => 'required'
        );
        $niceNames = array(
            'ModComSG' => 'Sigla',
            'ModComNM' => 'Nome'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);
        // process the login
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput(Input);
        } else {
            $data = $request->all();
            if(isset($data['ModComSQL'])) {
                $data['ModComSQL'] = 1;
            }
            ModCom::create($data);
            SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.modelo');
        }
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
