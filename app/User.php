<?php

namespace App;

use App\Models\Grupos;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',  'funcao',  'CredPortId',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->funcao == 1 ? true : false; // this looks for an admin column in your users table
    }
    public function isMaster()
    {
        return $this->funcao == 2 ? true : false; // this looks for an admin column in your users table
    }
    public function isServidor()
    {
        return $this->funcao == 3 ? true : false; // this looks for an admin column in your users table
    }
    public function isCidadao()
    {
        return $this->funcao == 4 ? true : false; // this looks for an admin column in your users table
    }

    // get list by condition
    public function menu()
    {
        $grupos= Grupos::find($this->funcao);
        $arr= json_decode($grupos->fun_menu_json,true) ;
        $html='';
        foreach($arr as $var){
            $html.='<li><a';
            $html.=$var["href"]?' href="'. route($var['href']).'">':'>';
            $html.=$var["icon"] && trim($var['icon'])!='fa'?'<i class="fa '.$var['icon'].'"></i>':'';
            $html.=$var['text'];
            $html.=$var["children"]?'<span class="fa fa-chevron-down"></span>':'';
            $html.= '</a>';
            if($var["children"]){
                $html.='<ul class="nav child_menu">';
                foreach($var['children'] as $var2){
                    $html.='<li><a';
                    $html.=$var2["href"]?' href="'. route($var2['href']).'">':'>';
                    $html.=$var2["icon"] && trim($var2['icon'])!='fa'?'<i class="fa '.$var2['icon'].'"></i>':'';
                    $html.=$var2['text'];
                    $html.=$var2["children"]?'<span class="fa fa-chevron-down"></span>':'';
                    $html.= '</a>';
                    if($var2["children"]){
                        $html.='<ul class="nav child_menu">';
                        foreach($var2['children'] as $var3){
                            $html.='<li><a';
                            $html.=$var3["href"]?' href="'. route($var3['href']).'">':'>';
                            $html.=$var3["icon"] && trim($var3['icon'])!='fa'?'<i class="fa '.$var3['icon'].'"></i>':'';
                            $html.=$var3['text'];
                            $html.=$var3["children"]?'<span class="fa fa-chevron-down"></span>':'';
                            $html.= '</a>';
                        }
                        $html.='</ul>';
                    }
                }
                $html.='</ul>';
            }
            $html.='</li>';
        }
        return $html;
    }
}
