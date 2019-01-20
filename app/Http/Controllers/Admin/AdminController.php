<?php

namespace App\Http\Controllers\Admin;

use App\Models\Carteira;
use App\Models\Parcela;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {

        if(auth()->user()->isCidadao()){
            return view('admin.cidadao.index');
        }
        if(auth()->user()->isAdmin()) {
            $parcela_qtde = Parcela::count('ParcelaId');
            $parcela_qtde = number_format($parcela_qtde, 0, '', '.');

            $parcela_qtde_aberta = DB::table('cda_parcela')->where("SitPagId", "61")->count();
            $parcela_qtde_aberta = number_format($parcela_qtde_aberta, 0, '', '.');

            $parcela_sum = Parcela::sum('TotalVr');
            $parcela_sum = number_format($parcela_sum, 2, ',', '.');

            $parcela_sum_aberta = DB::table('cda_parcela')->where("SitPagId", "61")->sum('TotalVr');
            $parcela_sum_aberta = number_format($parcela_sum_aberta, 2, ',', '.');
            $Origem = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 16");
            $Carteira = Carteira::all();
            $Fase = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 11");
            $FxAtraso = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 32");
            return view('admin.home.index',
                compact(
                    'Origem',
                    'Carteira',
                    'Fase',
                    'FxAtraso',
                    'parcela_qtde',
                    'parcela_qtde_aberta',
                    'parcela_sum',
                    'parcela_sum_aberta'
                )
            );
        }
    }

    public function debitos()
    {
        return view('admin.cidadao.debitos.index');
    }

    public function getDadosDataTable(Request $request)
    {
        $cda_parcela = Parcela::select([
            'cda_parcela.*',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            'SitPagT.REGTABNM as  SitPag',
            'SitCobT.REGTABNM as  SitCob',
            'OrigTribT.REGTABNM as  OrigTrib',
            'TributoT.REGTABNM as  Tributo',
            'Pessoa.PESSOANMRS as Nome'
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_pessoa as Pessoa', 'Pessoa.PESSOAID', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
            ->where('cda_parcela.PessoaId',Auth::user()->pessoa_id);
        $cda_parcela->get();
        return Datatables::of($cda_parcela)->make(true);
    }
}
