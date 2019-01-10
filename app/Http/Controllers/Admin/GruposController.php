<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grupos;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = Grupos::get();
        return view('admin.grupos.index',compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.grupos.create');
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
        Grupos::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('grupos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupos  $grupos
     * @return \Illuminate\Http\Response
     */
    public function show(Grupos $grupos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grupos  $grupos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // show the view and pass the nerd to it
        $Grupos = Grupos::find($id);

        if(empty($Grupos->fun_menu_json)){
            $Menus=Menu::all();
            $arr=[];
            $x=0;
            foreach ($Menus as $val){
                $arr[$x]['text']    =$val->menu_nome;
                $arr[$x]['href']    =$val->menu_url;
                $arr[$x]['icon']    ="fa ".$val->menu_icone;
                $arr[$x]['target']  =$val->menu_target;
                $x++;
            }
            $Menu=json_encode($arr);
        }else{
            $Menu=$Grupos->fun_menu_json;
        }

        return view('admin.grupos.edit',['Grupos'=>$Grupos,'Menu'=>$Menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grupos  $grupos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->except(['_token']);
        $Grupos = Grupos::findOrFail($id);
        $Grupos->update($data);

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('grupos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupos  $grupos
     * @return \Illuminate\Http\Response
     */
    public function destroy( $grupos)
    {
        $var = Grupos::find($grupos);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable()
    {
        $cda_grupos = Grupos::all();

        return Datatables::of($cda_grupos)
            ->addColumn('action', function ($grupos) {

                return '
                <a href="grupos/'.$grupos->fun_id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteGrupos('.$grupos->fun_id.')" class="btn btn-xs btn-danger deleteGrupos" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
