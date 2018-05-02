<?php

namespace App\Http\Controllers\Admin;

use App\Models\Carteira;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CarteiraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_carteira = DB::table('cda_carteira')->get();
        return view('admin.carteira.index',compact('cda_carteira'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $TPAS = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpAs')
            ->get();
        ;
        $OBJCART = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','ObjCart')
            ->get();
        ;
        $ORIGTRIB = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','OrigTrib')
            ->get();
        ;
        // show the view and pass the nerd to it
        return view('admin.carteira.create',[
            'TPAS'=>$TPAS,
            'OBJCART'=>$OBJCART,
            'ORIGTRIB'=>$ORIGTRIB
        ]);
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

        Carteira::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('carteira.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function show(Carteira $carteira)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $carteira = Carteira::find($id);

        $TPAS = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpAs')
            ->get();
        ;
        $OBJCART = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','ObjCart')
            ->get();
        ;
        $ORIGTRIB = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','OrigTrib')
            ->get();

        $EntCart = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','EntCart')
            ->get();

        $ExecRot = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','ExecRot')
            ->get();

        $FaseCart = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','FaseCart')
            ->get();

        $Evento = DB::table('cda_evento')->get();

        $ModCom = DB::table('cda_modcom')->get();

        $FilaTrab = DB::table('cda_filatrab')->get();

        $Canal = DB::table('cda_canal')->get();

        $RoteiroProx = DB::table('cda_roteiro')->get();

        // show the view and pass the nerd to it
        return view('admin.carteira.edit',[
            'Carteira'=>$carteira,
            'TPAS'=>$TPAS,
            'OBJCART'=>$OBJCART,
            'EntCart'=>$EntCart,
            'FaseCart'=>$FaseCart,
            'Evento'=>$Evento,
            'ModCom'=>$ModCom,
            'FilaTrab'=>$FilaTrab,
            'Canal'=>$Canal,
            'RoteiroProx'=>$RoteiroProx,
            'ExecRot'=>$ExecRot,
            'ORIGTRIB'=>$ORIGTRIB
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carteira = Carteira::findOrFail($id);
        $carteira->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('carteira.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function destroy($carteira)
    {
        $var = Carteira::find($carteira);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable()
    {
        $cda_carteira = Carteira::select(['CARTEIRAID','CARTEIRASG', 'CARTEIRANM']);

        return Datatables::of($cda_carteira)
            ->addColumn('action', function ($carteira) {

                return '
                <a href="carteira/'.$carteira->CARTEIRAID.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteCarteira('.$carteira->CARTEIRAID.')" class="btn btn-xs btn-danger deleteCarteira" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
