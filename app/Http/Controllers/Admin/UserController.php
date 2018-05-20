<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
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


class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();

        return view('admin.user.index',compact('users'));
    }

    public function getPosts()
    {
        $users = User::select(['id', 'name', 'email']);


        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '
                <a href="users/editar/'.$user->id.'" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteUser('.$user->id.')" class="btn btn-xs btn-danger deleteUser" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';


            })
            ->make(true);
    }

    public function getEditar($id)
    {
        // get the nerd
        $user = User::find($id);
        $funcoes = DB::select("SELECT * FROM cda_user_funcao ORDER BY fun_id");
        // show the view and pass the nerd to it
        return View::make('admin.user.form')
            ->with('funcoes', $funcoes)
            ->with('user', $user);
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
            $user = User::find($id);
            $user->name       = Input::get('name');
            $user->email      = Input::get('email');
            $user->save();

            // redirect
            SWAL::message('Salvo','Usuário foi salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.users');
        }
    }

    public function getInserir()
    {
        $funcoes = DB::select("SELECT * FROM cda_user_funcao ORDER BY fun_id");
        // show the view and pass the nerd to it
        return view('admin.user.insere',compact('funcoes'));
    }


    public function postInserir(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'password'      => 'required',
        );
        $niceNames = array(
            'name' => 'Nome',
            'password' => 'Senha'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);
        // process the login
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $data = $request->all();
            if($data['password']==$data['password2']) {
                $data['password'] = bcrypt($data['password']);
            }else {
                swal()->error('Erro!', 'As senhas estão diferentes!', []);
                return back()
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            }
            User::create($data);
            SWAL::message('Salvo','Usuário foi salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.users');
        }
    }

    public function postDeletar($id)
    {
        $user = User::find($id);
        if($user->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }
}
