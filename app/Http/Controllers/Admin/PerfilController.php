<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
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
        DB::beginTransaction();
        try {
            $id=auth()->user()->getAuthIdentifier();
            $update = User::find($id)->update($data);
            unset($data['_token']);
            unset($data['password2']);
            $update = User::on('mysql')->where('documento',auth()->user()->documento)->limit(1)->update($data);
            $update=auth()->user()->update($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
        }

        if($update) {
            SWAL::message('Salvo','Seu perfil foi salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
            return redirect()->route('perfil.ver')->with('success', 'Salvo com Sucesso!');
        }

        return redirect()->back()->with('error','Falha!');
    }

}
