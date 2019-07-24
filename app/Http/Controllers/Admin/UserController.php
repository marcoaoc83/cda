<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orgao;
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

        $orgao=auth()->user()->orgao;
        if($orgao)
            $users = User::select(['id', 'name', 'email'])->where('orgao',$orgao);
        else
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
        $orgao = Orgao::get();
        $funcoes = DB::select("SELECT * FROM cda_user_funcao ORDER BY fun_id");
        // show the view and pass the nerd to it
        return View::make('admin.user.form')
            ->with('orgaos', $orgao)
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
            DB::beginTransaction();
            try {
                // store
                $user = User::find($id);
                $documento=$user->documento;
                if($user->orgao){
                    $org=Orgao::on('mysql')->find($user->orgao);
                    $user = User::on($org->org_pasta)->find($id);
                }
                if(Input::get('orgao')) {
                    $user->update([
                        "name" => Input::get('name'),
                        "email" => Input::get('email'),
                        "funcao" => Input::get('funcao'),
                        "documento" => Input::get('documento'),
                        "orgao" => Input::get('orgao')
                    ]);
                }else{
                    $user->update([
                        "name" => Input::get('name'),
                        "email" => Input::get('email'),
                        "funcao" => Input::get('funcao'),
                        "documento" => Input::get('documento')
                    ]);
                }
                if(Input::get('password')) {
                    $user->update([

                        "password" => bcrypt(Input::get('password'))
                    ]);
                }

                $user2 = User::on('mysql')->where('documento',$documento);
                if(Input::get('orgao')) {
                    $user2->update([
                        "name" => Input::get('name'),
                        "email" => Input::get('email'),
                        "documento" => Input::get('documento'),
                        "funcao" => Input::get('funcao'),
                        "orgao" => Input::get('orgao')
                    ]);
                }else{
                    $user2->update([
                        "name" => Input::get('name'),
                        "email" => Input::get('email'),
                        "funcao" => Input::get('funcao'),
                        "documento" => Input::get('documento')
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
            }

            // redirect
            SWAL::message('Salvo','Usuário foi salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.users');
        }
    }

    public function getInserir()
    {
        $funcoes = DB::select("SELECT * FROM cda_user_funcao ORDER BY fun_id");
        $orgaos = Orgao::get();
        // show the view and pass the nerd to it
        return view('admin.user.insere',compact('funcoes','orgaos'));
    }


    public function postInserir(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'documento'      => 'required',
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

            DB::beginTransaction();
            try {

                $id=User::on('mysql')->create($data);
                $data = array_merge($data, [ 'id' =>$id->id]);
                if($data['orgao']){
                    $org=Orgao::on('mysql')->find($data['orgao']);
                    if($org->org_pasta && $org->org_pasta!='mysql')
                        User::on($org->org_pasta)->create($data);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
            }
            SWAL::message('Salvo','Usuário foi salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.users');
        }
    }

    public function postDeletar($id)
    {
        $user = User::find($id);
        if($user->delete()) {
            User::on('mysql')->find($id)->delete();
            return 'true';
        }else{
            return 'false';
        }
    }
}
