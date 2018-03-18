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
    public function userUpdate(Request $request)
    {
        $data = $request->all();

        if(empty($data['password'])){
            unset($data['password']);
        }else{
            if($data['password']==$data['password2']) {
                $data['password'] = bcrypt($data['password']);
            }else {
                swal()->error('Erro!', 'As senhas estão diferentes!', []);
                return redirect()->back()->with('error','Falha!');
            }

        }

        $update=auth()->user()->update($data);

        if($update) {
            SWAL::message('Salvo','Seu perfil foi salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('admin.user')->with('success', 'Salvo com Sucesso!');
        }

        return redirect()->back()->with('error','Falha!');
    }

    public function getPosts()
    {
        $users = User::select(['id', 'name', 'email']);


        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="users/editar/'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a>';
            })
            ->make(true);
    }

    public function getEditar($id)
    {
        // get the nerd
        $user = User::find($id);

        // show the view and pass the nerd to it
        return View::make('admin.user.form')
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
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('users/editar/' . $id . '')
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

}
