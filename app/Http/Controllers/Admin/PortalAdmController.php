<?php

namespace App\Http\Controllers\Admin;

use App\Models\PortalAdm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;

class PortalAdmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();

        return view('admin.portal.index')->with('Var',$Var[0]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        unset($data['_token']);
        unset($data['port_logo_topoTmp']);
        unset($data['port_logo_rodapeTmp']);
        unset($data['port_banner_lateralTmp']);
        unset($data['port_banner1Tmp']);
        unset($data['port_banner2Tmp']);
        unset($data['port_banner3Tmp']);
        unset($data['port_banner4Tmp']);
        unset($data['port_banner5Tmp']);

        $path='/images/portal/';
        if ($request->hasFile('port_logo_topo') && $request->port_logo_topo->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_logo_topo->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_logo_topo = $request->file('port_logo_topo');
            $port_logo_topo->move(public_path($path), $nameFile);
            $data['port_logo_topo'] = $nameFile;
        }

        if ($request->hasFile('port_logo_rodape') && $request->port_logo_rodape->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_logo_rodape->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_logo_rodape= $request->file('port_logo_rodape');
            $port_logo_rodape->move(public_path($path), $nameFile);
            $data['port_logo_rodape'] = $nameFile;
        }

        if ($request->hasFile('port_banner_lateral') && $request->port_banner_lateral->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_banner_lateral->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_banner_lateral= $request->file('port_banner_lateral');
            $port_banner_lateral->move(public_path($path), $nameFile);
            $data['port_banner_lateral'] = $nameFile;
        }

        if ($request->hasFile('port_banner1') && $request->port_banner1->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_banner1->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_banner1= $request->file('port_banner1');
            $port_banner1->move(public_path($path), $nameFile);
            $data['port_banner1'] = $nameFile;
        }

        if ($request->hasFile('port_banner2') && $request->port_banner2->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_banner2->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_banner2= $request->file('port_banner2');
            $port_banner2->move(public_path($path), $nameFile);
            $data['port_banner2'] = $nameFile;
        }

        if ($request->hasFile('port_banner3') && $request->port_banner3->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_banner3->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_banner3= $request->file('port_banner3');
            $port_banner3->move(public_path($path), $nameFile);
            $data['port_banner3'] = $nameFile;
        }

        if ($request->hasFile('port_banner4') && $request->port_banner4->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_banner4->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_banner4= $request->file('port_banner4');
            $port_banner4->move(public_path($path), $nameFile);
            $data['port_banner4'] = $nameFile;
        }

        if ($request->hasFile('port_banner5') && $request->port_banner5->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            // Recupera a extensão do arquivo
            $ext = $request->port_banner5->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}.{$ext}";

            $port_banner5= $request->file('port_banner5');
            $port_banner5->move(public_path($path), $nameFile);
            $data['port_banner5'] = $nameFile;
        }

        DB::table('cda_portal')->update($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('portal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function show(PortalAdm $portalAdm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function edit(PortalAdm $portalAdm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PortalAdm $portalAdm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PortalAdm  $portalAdm
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortalAdm $portalAdm)
    {
        //
    }
}
