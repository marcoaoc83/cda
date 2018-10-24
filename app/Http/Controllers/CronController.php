<?php

namespace App\Http\Controllers;

use App\Jobs\ImportacaoJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importacao(){
       // Artisan::call('queue:forget');
        Artisan::call('queue:work',["--timeout"=>1000,"--queue"=>"importacao"]);

    }
    public function distribuicao(Request $r){
       // Artisan::call('queue:forget');
        Artisan::call('queue:work',["--timeout"=>1000,"--queue"=>"distribuicao".$r->x]);

    }
    public function execfila(){
        // Artisan::call('queue:forget');
        Artisan::call('queue:work',["--timeout"=>1000,"--queue"=>"execfila"]);

    }
    public function execfilaparcela(){
        // Artisan::call('queue:forget');
        Artisan::call('queue:work',["--timeout"=>1000,"--queue"=>"execfilaparcela"]);

    }
}
