<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        return view('admin.perfil.index');
    }
    public function editar(Request $request)
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
            return redirect()->route('perfil.ver')->with('success', 'Salvo com Sucesso!');
        }

        return redirect()->back()->with('error','Falha!');
    }

}
