<?php

namespace App\Http\Controllers\Admin;

use App\Models\Canal;
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

class CanalController extends Controller
{
    public function index()
    {
        $cda_canal = DB::table('cda_canal')->get();

        return view('admin.canal.index',compact('cda_canal'));
    }

    public function getPosts()
    {
        $cda_canal = Canal::select(['CANALID', 'CANALSG', 'CANALNM'])->orderBy('CANALSG');

        return Datatables::of($cda_canal)
            ->addColumn('action', function ($canal) {

                return '
                <a href="canal/editar/'.$canal->CANALID.'" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteCanal('.$canal->CANALID.')" class="btn btn-xs btn-danger deleteCanal" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function getEditar($id)
    {
        // get the nerd
        $canal = Canal::find($id);
        $ValEnv = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','ValEnv')
            ->get();

        $Evento = DB::table('cda_evento')
        ->orderBy('EventoOrd')
        ->get();

        $Eventos = DB::table('cda_evento')
            ->orderBy('EventoSg')
            ->get();

        $TratRet = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TratRet')
            ->get();

        $TipPos = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpPos')
            ->get();

        // show the view and pass the nerd to it
        return View::make('admin.canal.form')
            ->with('canal', $canal)
            ->with('Evento', $Evento)
            ->with('Eventos', $Eventos)
            ->with('ValEnv', $ValEnv)
            ->with('TipPos', $TipPos)
            ->with('TratRet', $TratRet);
    }

    public function postEditar(Request $request, $id)
    {


        $canal = Canal::findOrFail($id);
        $canal->CANALSG       = $request->CANALSG;
        $canal->CANALNM       = $request->CANALNM;
        $canal->save();
        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('admin.canal');

    }

    public function getInserir()
    {

        // show the view and pass the nerd to it
        return view('admin.canal.insere',compact('cda_canal'));
    }


    public function postInserir(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'CANALSG'       => 'required',
            'CANALNM'      => 'required'
        );
        $niceNames = array(
            'CANALSG' => 'Sigla',
            'CANALNM' => 'Nome'
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
            if(isset($data['CANALSQL'])) {
                $data['CANALSQL'] = 1;
            }
            Canal::create($data);
            SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.canal');
        }
    }

    public function postDeletar($id)
    {
        $canal = Canal::find($id);
        if($canal->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }
}
