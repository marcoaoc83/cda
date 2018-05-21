<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $user=User::find(auth()->user()->id);
        if($user->funcao==4){
            return view('admin.cidadao.index');
        }
        return view('admin.home.index');
    }
}
