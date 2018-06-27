<?php

namespace App\Http\Controllers;

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
        $sql="Select
                  cda_parcela.ParcelaId,
                  cda_parcela.PessoaId,
                  cda_parcela.SITPAGID,
                  cda_parcela.SITCOBID,
                  cda_parcela.INSCRMUNID,
                  cda_parcela.ORIGTRIBID,
                  cda_parcela.TRIBUTOID,
                  cda_parcela.LANCAMENTODT,
                  cda_parcela.LANCAMENTONR,
                  cda_parcela.VENCIMENTODT,
                  cda_parcela.PARCELANR,
                  cda_parcela.PLANOQT,
                  cda_parcela.PRINCIPALVR,
                  cda_parcela.MULTAVR,
                  cda_parcela.JUROSVR,
                  cda_parcela.TaxaVr,
                  cda_parcela.ACRESCIMOVR,
                  cda_parcela.DESCONTOVR,
                  cda_parcela.Honorarios,
                  cda_parcela.TOTALVR,
                  cda_regtab.REGTABSG
                From
                  cda_parcela
                  Inner Join
                  cda_regtab On cda_parcela.SITPAGID = cda_regtab.REGTABID
                Where
                  (cda_parcela.VENCIMENTODT Is Not Null) And
                  (cda_regtab.REGTABSG = 'A')";
        ini_set('memory_limit', '-1');
        $consulta= DB::select($sql)->limit(100);
        dd($consulta);
        $where="";
        foreach ($consulta as $parcelas){

            $sql_carteiras="Select
                              cda_carteira.CARTEIRAID,
                              cda_carteira.CARTEIRAORD,
                              cda_carteira.CARTEIRASG,
                              cda_carteira.CARTEIRANM,
                              cda_carteira.TPASID,
                              cda_carteira.OBJCARTID,
                              cda_carteira.ORIGTRIBID
                            From
                              cda_carteira";
            $consulta_carteiras= DB::select($sql_carteiras);
            foreach ($consulta_carteiras as $carteiras) {

                $sql2 = "Select
                      cda_entcart.CarteiraId,
                      cda_entcart.EntCartId,
                      cda_entcart.AtivoSN,
                      cda_regtab.REGTABSG,
                      cda_regtab.REGTABNM,
                      cda_regtab.REGTABSQL
                    From
                      cda_entcart
                      Inner Join
                      cda_regtab On cda_entcart.EntCartId = cda_regtab.REGTABID
                    Where
                      (cda_entcart.CarteiraId = {$carteiras->CARTEIRAID}) And
                      (cda_entcart.AtivoSN = True)";
                $consulta2 = DB::select($sql2);
                foreach ($consulta2 as $linha2) {
                    $where .= " ".$linha2->REGTABSQL;
                }

                $sql_pric = "SELECT ParcelaId FROM cda_parcela WHERE ParcelaId =" . $parcelas->ParcelaId;
                $sql_pric .= $where;

                $consulta_prin = DB::select($sql_pric);
                if (count($consulta_prin) > 0) {

                    $sql_roteiro = "SELECT cda_roteiro.roteiroid,
                                   cda_roteiro.carteiraid,
                                   cda_roteiro.roteiroord,
                                   cda_roteiro.fasecartid,
                                   cda_roteiro.eventoid,
                                   cda_roteiro.modcomid,
                                   cda_roteiro.filatrabid,
                                   cda_roteiro.canalid,
                                   cda_roteiro.roteiroproxid
                            FROM   cda_roteiro
                            WHERE  cda_roteiro.carteiraid = {$carteiras->CARTEIRAID}
                            ORDER  BY cda_roteiro.roteiroord ";

                    $consulta_roteiro = DB::select($sql_roteiro);

                    foreach ($consulta_roteiro as $roteiros) {
                        $where_roteiro = null;
                        $sql_var_roteiro = "Select
                                          cda_execrot.CarteiraId,
                                          cda_execrot.RoteiroId,
                                          cda_execrot.ExecRotId,
                                          cda_execrot.AtivoSN,
                                          cda_regtab.REGTABSQL
                                        From
                                          cda_execrot
                                          Inner Join
                                          cda_regtab On cda_execrot.ExecRotId = cda_regtab.REGTABID
                                        Where
                                          (cda_execrot.RoteiroId = {$roteiros->roteiroid}) And
                                          (cda_execrot.AtivoSN = True)";
                        $consulta_var_roteiro = DB::select($sql_var_roteiro);
                        foreach ($consulta_var_roteiro as $var_roteiros) {
                            $where_roteiro .= " ".$var_roteiros->REGTABSQL;
                        }
                        if (empty($where_roteiro)) {
                            continue;
                        }

                        $sql_monta_roteiro = "SELECT ParcelaId FROM cda_parcela WHERE ParcelaId =" . $parcelas->ParcelaId;
                        $sql_monta_roteiro .= $where_roteiro;
                        $consulta_monta_roteiro = DB::select($sql_monta_roteiro);

                        if (count($consulta_monta_roteiro) <= 0) {
                            continue;
                        }

                        $sql_exec = "Select
                                  cda_pcrot.CarteiraId,
                                  cda_pcrot.ParcelaId,
                                  cda_pcrot.RoteiroId,
                                  cda_pcrot.EntradaDt,
                                  cda_pcrot.SaidaDt
                                From
                                  cda_pcrot
                                Where
                                  (cda_pcrot.CarteiraId = {$carteiras->CARTEIRAID}) And
                                  (cda_pcrot.ParcelaId = {$parcelas->ParcelaId}) And
                                  (cda_pcrot.SaidaDt Is Null)";
                        $consulta_exec = DB::select($sql_exec);

                        if (count($consulta_exec) > 0) {
                            if ($consulta_exec[0]->RoteiroId == $roteiros->roteiroid) {
                                continue;
                            } else {
                                DB::update("UPDATE cda_pcrot SET SaidaDt=NOW() WHERE CarteiraId= {$carteiras->CARTEIRAID} AND ParcelaId={$parcelas->ParcelaId} AND RoteiroId=" . $roteiros->roteiroid);
                            }
                        }
                        DB::insert("INSERT INTO cda_pcrot SET EntradaDt=NOW() , CarteiraId= {$carteiras->CARTEIRAID} , ParcelaId={$parcelas->ParcelaId} , RoteiroId=" . $roteiros->roteiroid);
                    }
                }
            }
        }
        echo true;
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
}
