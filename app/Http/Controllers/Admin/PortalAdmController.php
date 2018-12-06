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

        $path='/images/portal/';
        if ($request->hasFile('port_logo_topo') && $request->port_logo_topo->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_logo_topo->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_logo_topo->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_logo_topo = $request->file('port_logo_topo');
            $port_logo_topo->move(public_path($path), $nameFile);
            $data['port_logo_topo'] = $nameFile;
        }
        if(!$data['port_logo_topoTmp']){
            $data['port_logo_topo'] = '';
        }
        if ($request->hasFile('port_logo_rodape') && $request->port_logo_rodape->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_logo_rodape->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_logo_rodape->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_logo_rodape= $request->file('port_logo_rodape');
            $port_logo_rodape->move(public_path($path), $nameFile);
            $data['port_logo_rodape'] = $nameFile;
        }
        if(!$data['port_logo_rodapeTmp']){
            $data['port_logo_rodape'] = '';
        }
        if ($request->hasFile('port_banner_lateral') && $request->port_banner_lateral->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_banner_lateral->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_banner_lateral->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_banner_lateral= $request->file('port_banner_lateral');
            $port_banner_lateral->move(public_path($path), $nameFile);
            $data['port_banner_lateral'] = $nameFile;
        }
        if(!$data['port_banner_lateralTmp']){
            $data['port_banner_lateral'] = '';
        }
        if ($request->hasFile('port_banner1') && $request->port_banner1->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_banner1->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_banner1->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_banner1= $request->file('port_banner1');
            $port_banner1->move(public_path($path), $nameFile);
            $data['port_banner1'] = $nameFile;
        }
        if(!$data['port_banner1Tmp']){
            $data['port_banner1'] = '';
        }
        if ($request->hasFile('port_banner2') && $request->port_banner2->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_banner2->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_banner2->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_banner2= $request->file('port_banner2');
            $port_banner2->move(public_path($path), $nameFile);
            $data['port_banner2'] = $nameFile;
        }
        if(!$data['port_banner2Tmp']){
            $data['port_banner2'] = '';
        }
        if ($request->hasFile('port_banner3') && $request->port_banner3->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_banner3->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_banner3->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_banner3= $request->file('port_banner3');
            $port_banner3->move(public_path($path), $nameFile);
            $data['port_banner3'] = $nameFile;
        }
        if(!$data['port_banner3Tmp']){
            $data['port_banner3'] = '';
        }
        if ($request->hasFile('port_banner4') && $request->port_banner4->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_banner4->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_banner4->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_banner4= $request->file('port_banner4');
            $port_banner4->move(public_path($path), $nameFile);
            $data['port_banner4'] = $nameFile;
        }
        if(!$data['port_banner4Tmp']){
            $data['port_banner4'] = '';
        }
        if ($request->hasFile('port_banner5') && $request->port_banner5->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_banner5->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_banner5->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_banner5= $request->file('port_banner5');
            $port_banner5->move(public_path($path), $nameFile);
            $data['port_banner5'] = $nameFile;
        }
        if(!$data['port_banner5Tmp']){
            $data['port_banner5'] = '';
        }
        if ($request->hasFile('port_icone_top') && $request->port_icone_top->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_icone_top->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_icone_top->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_icone_top= $request->file('port_icone_top');
            $port_icone_top->move(public_path($path), $nameFile);
            $data['port_icone_top'] = $nameFile;
        }
        if(!$data['port_icone_topTmp']){
            $data['port_icone_top'] = '';
        }
        if ($request->hasFile('port_icone_1') && $request->port_icone_1->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_icone_1->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_icone_1->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_icone_1= $request->file('port_icone_1');
            $port_icone_1->move(public_path($path), $nameFile);
            $data['port_icone_1'] = $nameFile;
        }
        if(!$data['port_icone_1Tmp']){
            $data['port_icone_1'] = '';
        }
        if ($request->hasFile('port_icone_2') && $request->port_icone_2->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_icone_2->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_icone_2->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_icone_2= $request->file('port_icone_2');
            $port_icone_2->move(public_path($path), $nameFile);
            $data['port_icone_2'] = $nameFile;
        }
        if(!$data['port_icone_2Tmp']){
            $data['port_icone_2'] = '';
        }
        if ($request->hasFile('port_icone_3') && $request->port_icone_3->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_icone_3->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_icone_3->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_icone_3= $request->file('port_icone_3');
            $port_icone_3->move(public_path($path), $nameFile);
            $data['port_icone_3'] = $nameFile;
        }
        if(!$data['port_icone_3Tmp']){
            $data['port_icone_3'] = '';
        }
        if ($request->hasFile('port_icone_4') && $request->port_icone_4->isValid()) {

            //Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            $name = $request->port_icone_4->getClientOriginalName();
            // Recupera a extensão do arquivo
            $ext = $request->port_icone_4->getClientOriginalExtension();
            // Define finalmente o nome
            $nameFile = "{$name}";

            $port_icone_4= $request->file('port_icone_4');
            $port_icone_4->move(public_path($path), $nameFile);
            $data['port_icone_4'] = $nameFile;
        }
        if(!$data['port_icone_4Tmp']){
            $data['port_icone_4'] = '';
        }
        unset($data['_token']);
        unset($data['port_logo_topoTmp']);
        unset($data['port_logo_rodapeTmp']);
        unset($data['port_banner_lateralTmp']);
        unset($data['port_banner1Tmp']);
        unset($data['port_banner2Tmp']);
        unset($data['port_banner3Tmp']);
        unset($data['port_banner4Tmp']);
        unset($data['port_banner5Tmp']);
        unset($data['port_icone_1Tmp']);
        unset($data['port_icone_2Tmp']);
        unset($data['port_icone_3Tmp']);
        unset($data['port_icone_4Tmp']);
        unset($data['port_icone_topTmp']);

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
