<?php

namespace App\Http\Controllers\Admin;

use App\Models\Legislacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class LegislacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $legislacao = DB::table('cda_portal_legislacao')->get();
        return view('admin.legislacao.index',compact('legislacao'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // show the view and pass the nerd to it
        return view('admin.legislacao.create');
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

        $path='/uploads/';
        if ($request->hasFile('leg_arquivo') && $request->leg_arquivo->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->leg_arquivo->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $leg_arquivo = $request->file('leg_arquivo');
            $leg_arquivo->move(public_path($path), $nameFile);
            $data['leg_arquivo'] = $nameFile;
        }
        Legislacao::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('legislacao.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislacao  $legislacao
     * @return \Illuminate\Http\Response
     */
    public function show(Legislacao $legislacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Legislacao  $legislacao
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // show the view and pass the nerd to it
        $Legislacao = Legislacao::find($id);
        return view('admin.legislacao.edit',[
            'Legislacao'=>$Legislacao
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legislacao  $legislacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $path='/uploads/';
        $data=$request->except(['_token']);
        unset($data['leg_arquivo']);
        if ($request->hasFile('leg_arquivo') && $request->leg_arquivo->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->leg_arquivo->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $leg_arquivo = $request->file('leg_arquivo');
            $leg_arquivo->move(public_path($path), $nameFile);
            $data['leg_arquivo'] = $nameFile;
        }
        $Legislacao = Legislacao::findOrFail($id);
        $Legislacao->update($data);

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('legislacao.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legislacao  $legislacao
     * @return \Illuminate\Http\Response
     */
    public function destroy( $legislacao)
    {
        $var = Legislacao::find($legislacao);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable()
    {
        $Legislacao = Legislacao::select(['*'])->get();

        return Datatables::of($Legislacao)
            ->addColumn('action', function ($legislacao) {
                return '
                <a href="legislacao/'.$legislacao->leg_id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteLegislacao('.$legislacao->leg_id.')" class="btn btn-xs btn-danger deleteLegislacao" >
                    <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
