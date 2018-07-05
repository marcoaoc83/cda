<?php

namespace App\Http\Controllers;

use App\Jobs\ImportacaoJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       // Artisan::call('queue:forget');
        Artisan::call('queue:work',["--timeout"=>1000,"--queue"=>"importacao"]);
        Artisan::call('queue:work',["--timeout"=>1000,"--queue"=>"distribuicao"]);
    }
}
