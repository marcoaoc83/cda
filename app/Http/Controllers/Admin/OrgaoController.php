<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orgao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class OrgaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_orgao =Orgao::get();
        return view('admin.orgao.index',compact('cda_orgao'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // show the view and pass the nerd to it
        return view('admin.orgao.create');

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
        Orgao::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('orgao.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orgao  $orgao
     * @return \Illuminate\Http\Response
     */
    public function show(Orgao $orgao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orgao  $orgao
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $orgao = Orgao::find($id);

        // show the view and pass the nerd to it
        return view('admin.orgao.edit',[
            'Orgao'=>$orgao
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orgao  $orgao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $orgao = Orgao::findOrFail($id);
        $orgao->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('orgao.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orgao  $orgao
     * @return \Illuminate\Http\Response
     */
    public function destroy($orgao)
    {
        $var = Orgao::find($orgao);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }
    public function getDadosDataTable()
    {
        $cda_orgao = Orgao::all();

        return Datatables::of($cda_orgao)
            ->addColumn('action', function ($orgao) {

                return '
                <a href="orgao/'.$orgao->org_id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteOrgao('.$orgao->org_id.')" class="btn btn-xs btn-danger deleteOrgao" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
