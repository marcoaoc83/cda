<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_pessoa = DB::table('cda_pessoa')->get();
        return view('admin.pessoa.index',compact('cda_pessoa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // show the view and pass the nerd to it
        return view('admin.pessoa.create');

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
        $data['CPF_CNPJNR']=preg_replace('/[^0-9]/','',$data['CPF_CNPJNR']);
        Pessoa::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('pessoa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function show(Pessoa $pessoa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $pessoa = Pessoa::find($id);

        $ORIGTRIB = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','OrigTrib')
            ->get();

        $FonteInfoId = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','FonteInfo')
            ->get();

        $Canal = DB::table('cda_canal')->get();

        $PessoaIdSR = DB::table('cda_pessoa')->get();

        $TipPos = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpPos')
            ->get();

        // show the view and pass the nerd to it
        return view('admin.pessoa.edit',[
            'Pessoa'=>$pessoa,
            'FonteInfoId'=>$FonteInfoId,
            'Canal'=>$Canal,
            'TipPos'=>$TipPos,
            'PessoaIdSR'=>$PessoaIdSR,
            'ORIGTRIB'=>$ORIGTRIB
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request['CPF_CNPJNR']=preg_replace('/[^0-9]/','',$request['CPF_CNPJNR']);
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('pessoa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function destroy($pessoa)
    {
        $var = Pessoa::find($pessoa);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable()
    {
        $cda_pessoa = Pessoa::select(['PESSOAID','PESSOANMRS', 'CPF_CNPJNR']);

        return Datatables::of($cda_pessoa)
            ->addColumn('action', function ($pessoa) {

                return '
                <a href="pessoa/'.$pessoa->PESSOAID.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deletePessoa('.$pessoa->PESSOAID.')" class="btn btn-xs btn-danger deletePessoa" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
