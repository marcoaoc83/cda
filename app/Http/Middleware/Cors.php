<?php

namespace App\Http\Middleware;

use App\Models\Orgao;
use Closure;
use Illuminate\Support\Facades\DB;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $connection = config('database.default');
        $pdo =  config("database.connections.{$connection}.driver");

        if($pdo=='mysql'){
            if( auth()->user()->orgao){
                $orgao=Orgao::find(  auth()->user()->orgao);
                DB::setDefaultConnection($orgao->org_pasta);
            }else{
                DB::setDefaultConnection('mysql');

            }
        }
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
