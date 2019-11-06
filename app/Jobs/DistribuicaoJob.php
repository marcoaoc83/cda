<?php

namespace App\Jobs;

use App\Models\Carteira;
use App\Models\EntCart;
use App\Models\ExecRot;
use App\Models\Parcela;
use App\Models\PcRot;
use App\Models\Roteiro;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class DistribuicaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $page;
    protected $x;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page=0,$x)
    {
        $this->page=$page;
        $this->x=$x;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $consulta= Parcela::select(['cda_parcela.ParcelaId'])
            ->leftjoin('distribuicao_parcelas', 'cda_parcela.ParcelaId', '=', 'distribuicao_parcelas.parcela_id')
            ->whereNull('distribuicao_parcelas.parcela_id')
            ->whereNotNull('cda_parcela.VENCIMENTODT')
            ->where('cda_parcela.SitPagId',61)
            ->limit(50)
            ->offset($this->page);
        //Log::notice('1 - '.date('H:i:s'));
        foreach ($consulta->cursor() as $parcelas){
            DB::beginTransaction();
            try {
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
                                continue;
                            }

                            /* Verifica se ja existe roteira para aquela parcela*/
                            $consulta_exec = PcRot::where('cda_pcrot.ParcelaId',$parcelas->ParcelaId)->whereNull('cda_pcrot.SaidaDt');
                            $consulta_exec = (is_array($consulta_exec) ? count($consulta_exec) : 0);
                            if (($consulta_exec) > 0) {continue;}


                            $consulta_exec = PcRot::select([
                                'cda_pcrot.RoteiroId'
                            ])
                                ->where('cda_pcrot.CarteiraId',$carteiras->CARTEIRAID)
                                ->where('cda_pcrot.ParcelaId',$parcelas->ParcelaId)
                                ->whereNull('cda_pcrot.SaidaDt')->get();
                            ;

                            $consulta_exec = (is_array($consulta_exec) ? count($consulta_exec) : 0);
                            if (($consulta_exec) > 0) {
                                if ($consulta_exec[0]->RoteiroId == $roteiros->RoteiroId) {
                                    continue;
                                } else {
                                    DB::update("UPDATE cda_pcrot SET SaidaDt=NOW() WHERE CarteiraId= {$carteiras->CARTEIRAID} AND ParcelaId={$parcelas->ParcelaId} AND RoteiroId=" . $consulta_exec[0]->RoteiroId);
                                }
                            }
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
            ->limit(50)
            ->offset($this->page)->get();
        if(count($consulta)>0){
            //Log::notice(count($consulta));
            DistribuicaoJob::dispatch($this->page,$this->x)->onQueue("distribuicao".$this->x);
        }
        Artisan::call('queue:restart');
        echo true;
    }
}
