<?php

namespace App\Http\Controllers;

use App\Jobs\DistribuicaoJob;
use App\Models\Carteira;
use App\Models\EntCart;
use App\Models\ExecRot;
use App\Models\Parcela;
use App\Models\PcRot;
use App\Models\Roteiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistribuicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pag=0;
        for($x=1;$x<=10;$x++) {
            DistribuicaoJob::dispatch($pag,$x)->onQueue("distribuicao".$x);
            $pag=$pag+50;
        }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function truncate()
    {
        DB::table('distribuicao_parcelas')->truncate();
    }

    public function teste(Request $request)
    {
        $page=$request->page??0;
        $consulta= Parcela::select(['cda_parcela.ParcelaId'])
            ->leftjoin('distribuicao_parcelas', 'cda_parcela.ParcelaId', '=', 'distribuicao_parcelas.parcela_id')
            ->whereNull('distribuicao_parcelas.parcela_id')
            ->whereNotNull('cda_parcela.VENCIMENTODT')
            ->where('cda_parcela.SitPagId',61)
            ->limit(5000)
            ->offset($page);
        //Log::notice('1 - '.date('H:i:s'));
        foreach ($consulta->cursor() as $parcelas){
            DB::beginTransaction();
            try {

                $PCRot=PcRot::where('ParcelaId', $parcelas->ParcelaId)->whereNull('SaidaDt')->get();
                $PCRot=$PCRot[0];
                $consulta_carteiras=Carteira::query()->orderBy('CARTEIRAORD');
                //Log::notice('2 - '.date('H:i:s'));
                foreach ($consulta_carteiras->cursor() as $carteiras) {

                    $where="";
                    $consulta2 = EntCart::select(['cda_regtab.REGTABSQL'])
                        ->join('cda_regtab','cda_entcart.EntCartId','=','cda_regtab.REGTABID')
                        ->where('cda_entcart.CarteiraId',$carteiras->CARTEIRAID)
                        ->where('cda_entcart.AtivoSN',True);
                    foreach ($consulta2->cursor() as $linha2) {
                        $where .= " " . $linha2->REGTABSQL;
                    }
                    //Log::notice('3 - '.date('H:i:s'));
                    $sql_pric = "SELECT ParcelaId FROM cda_parcela WHERE ParcelaId =" . $parcelas->ParcelaId;
                    $sql_pric .= $where;

                    $consulta_prin = DB::select($sql_pric);
                    $consulta_prin = (is_array($consulta_prin) ? count($consulta_prin) : 0);
                    if (($consulta_prin) > 0) {

                        $consulta_roteiro = Roteiro::select(['RoteiroId'])->where('cda_roteiro.CarteiraId',$carteiras->CARTEIRAID)->orderBy('cda_roteiro.RoteiroOrd');

                        foreach ($consulta_roteiro->cursor() as $roteiros) {
                            //Log::notice('4 - '.date('H:i:s'));
                            $where_roteiro = null;
                            $consulta_var_roteiro = ExecRot::select([
                                'cda_regtab.REGTABSQL'
                            ])
                                ->join('cda_regtab','cda_execrot.ExecRotId','=','cda_regtab.REGTABID')
                                ->where('cda_execrot.RoteiroId',$roteiros->RoteiroId)
                                ->where('cda_execrot.AtivoSN',True)
                            ;
                            foreach ($consulta_var_roteiro->cursor() as $var_roteiros) {
                                $where_roteiro .= " " . $var_roteiros->REGTABSQL;
                            }
                            if (empty($where_roteiro)) {
                                continue;
                            }

                            $sql_monta_roteiro = "SELECT ParcelaId FROM cda_parcela WHERE ParcelaId =" . $parcelas->ParcelaId;
                            $sql_monta_roteiro .= $where_roteiro;
                            $consulta_monta_roteiro = DB::select($sql_monta_roteiro);
                            $consulta_monta_roteiro = (is_array($consulta_monta_roteiro) ? count($consulta_monta_roteiro) : 0);

                            if (($consulta_monta_roteiro) <= 0) {
                                if($PCRot->RoteiroId == $roteiros->RoteiroId){
                                    DB::update("UPDATE cda_pcrot SET SaidaDt=NOW() WHERE  pcrot_id=".$PCRot->pcrot_id);
                                }
                                continue;
                            }


                            $consulta_exec = PcRot::select([
                                'cda_pcrot.RoteiroId'
                            ])
                                ->where('cda_pcrot.CarteiraId',$carteiras->CARTEIRAID)
                                ->where('cda_pcrot.ParcelaId',$parcelas->ParcelaId)
                                ->whereNull('cda_pcrot.SaidaDt')->get();
                            ;

                            if (count($consulta_exec) > 0) {
                                if ($consulta_exec[0]->RoteiroId == $roteiros->RoteiroId) {
                                    continue;
                                } else {
                                    DB::update("UPDATE cda_pcrot SET SaidaDt=NOW() WHERE CarteiraId= {$carteiras->CARTEIRAID} AND ParcelaId={$parcelas->ParcelaId} AND RoteiroId=" . $consulta_exec[0]->RoteiroId);
                                }
                            }

                            /* Verifica se ja existe roteiro para aquela parcela*/
                            $consulta_exist = PcRot::where('cda_pcrot.ParcelaId',$parcelas->ParcelaId)->whereNull('cda_pcrot.SaidaDt')->get();
                            if (count($consulta_exist) > 0) {continue;}
                            DB::insert("INSERT INTO cda_pcrot SET EntradaDt=NOW() , CarteiraId= {$carteiras->CARTEIRAID} , ParcelaId={$parcelas->ParcelaId} , RoteiroId=" . $roteiros->RoteiroId);

                        }
                    }
                }
                DB::insert("INSERT INTO distribuicao_parcelas SET  parcela_id='".$parcelas->ParcelaId."' ON DUPLICATE KEY UPDATE  parcela_id='".$parcelas->ParcelaId."' ");
                DB::commit();
            } catch (\Exception $e) {
                echo $e->getMessage();
                DB::rollback();
            }
        }
        $consulta= Parcela::leftjoin('distribuicao_parcelas', 'cda_parcela.ParcelaId', '=', 'distribuicao_parcelas.parcela_id')
            ->whereNull('distribuicao_parcelas.parcela_id')
            ->whereNotNull('cda_parcela.VENCIMENTODT')
            ->where('cda_parcela.SitPagId',61)
            ->limit(5000)
            ->offset($page)->get();
        $sql="DELETE a FROM cda_pcrot AS a, cda_pcrot AS b WHERE a.CarteiraId=b.CarteiraId  and a.ParcelaId=b.ParcelaId and a.SaidaDt is null and b.SaidaDt is null AND a.pcrot_id > b.pcrot_id";
        DB::query($sql);
        echo true;
    }

}
