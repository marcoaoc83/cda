<?php

namespace App\Http\Controllers\Admin;

use App\Models\Parcela;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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

            return view('admin.home.index', compact('parcela_qtde', 'parcela_qtde_aberta', 'parcela_sum', 'parcela_sum_aberta'));
        }
    }

    public function debitos()
    {
        return view('admin.cidadao.debitos.index');
    }
}
