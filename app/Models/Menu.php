<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'menu_nome','menu_url','menu_icone','menu_target','menu_ativo'
    ];
    protected $table = 'cda_menu';
    protected $primaryKey = 'menu_id';
    public $timestamps = false;
}
