<?php

namespace App\Http\Controllers\Admin;

use App\Models\TabelasSistema;
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

class TabelasSistemaController extends Controller
{
    public function index()
    {
        $cda_tabsys = DB::table('cda_tabsys')->get();

        return view('admin.tabsys.index',compact('cda_tabsys'));
    }

    public function getPosts()
    {
        $cda_tabsys = TabelasSistema::select(['TABSYSID', 'TABSYSSG', 'TABSYSNM', 'TABSYSSQL']);

        return Datatables::of($cda_tabsys)
            ->addColumn('action', function ($tabsys) {
                return;
                return '
                <a href="tabsys/editar/'.$tabsys->id.'" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteTabelasSistema('.$tabsys->id.')" class="btn btn-xs btn-danger deleteTabelasSistema" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->editColumn('TABSYSSQL', function ($tabsys) {
                if($tabsys->TABSYSSQL=='1'){
                    return 'SIM';
                }else{
                    return 'NÃO';
                }

            })
            ->make(true);
    }

    public function getEditar($id)
    {
        // get the nerd
        $tabsys = TabelasSistema::find($id);

        // show the view and pass the nerd to it
        return View::make('admin.tabsys.form')
            ->with('tabsys', $tabsys);
    }

    public function postEditar($id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
        );
        $niceNames = array(
            'name' => 'Nome'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);
        // process the login
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $tabsys = TabelasSistema::find($id);
            $tabsys->name       = Input::get('name');
            $tabsys->email      = Input::get('email');
            $tabsys->save();

            // redirect
            SWAL::message('Salvo','Usuário foi salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.cda_tabsys');
        }
    }

    public function getInserir()
    {

        // show the view and pass the nerd to it
        return view('admin.tabsys.insere',compact('cda_tabsys'));
    }


    public function postInserir(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'TABSYSSG'       => 'required',
            'TABSYSNM'      => 'required'
        );
        $niceNames = array(
            'TABSYSSG' => 'Sigla',
            'TABSYSNM' => 'Nome'
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
            if(isset($data['TABSYSSQL'])) {
                $data['TABSYSSQL'] = 1;
            }
            TabelasSistema::create($data);
            SWAL::message('Salvo','Tabela foi salva com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.tabsys');
        }
    }

    public function postDeletar($id)
    {
        $tabsys = TabelasSistema::find($id);
        if($tabsys->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }
}
